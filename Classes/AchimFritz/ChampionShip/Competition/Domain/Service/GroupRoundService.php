<?php
namespace AchimFritz\ChampionShip\Competition\Domain\Service;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use AchimFritz\ChampionShip\Competition\Domain\Model\CrossGroupWithThirdsMatch;
use AchimFritz\ChampionShip\Competition\Domain\Model\Cup;
use AchimFritz\ChampionShip\Competition\Domain\Model\GroupRound;
use AchimFritz\ChampionShip\Competition\Domain\Model\KoMatch;
use AchimFritz\ChampionShip\Competition\Domain\Policy\GroupTable\BestThirdsPolicy;
use Neos\Flow\Annotations as Flow;

/**
 * @Flow\Scope("singleton")
 */
class GroupRoundService
{

    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\GroupRoundRepository
     */
    protected $groupRoundRepository;

    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\CrossGroupWithThirdsMatchRepository
     */
    protected $matchRepository;

    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\CrossGroupMatchRepository
     */
    protected $crossGroupMatchRepository;

    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\TeamsOfTwoMatchesMatchRepository
     */
    protected $teamsOfTwoMatchesMatchRepository;

    /**
     * @param Cup $cup
     * @return void
     * @throws Exception
     */
    public function finish(Cup $cup)
    {
        // group table of best 4 thirds
        $groupTableRows = $this->buildGroupTableRows($cup);
        // string by alpha sort -> A C D E
        $roundString = $this->buildRoundsString($groupTableRows);
        $policy = $this->getPolicy();
        $roundMatrix = $policy->getRoundMatrix($cup);
        if (empty($roundMatrix[$roundString]) === true) {
            throw new Exception('no matrix round found for ' . $roundString, 1464109832);
        }
        $combination = $roundMatrix[$roundString];
        $roundsForMatches = $this->getPolicy()->getOrderRoundsForMatches($cup);
        // string by alpha sort -> A C D E
        // A C D E         C       D       A       E
        // Spiel mit 1. Gruppe A -> 3 C
        // Spiel mit 1. Gruppe B -> 3 D
        // Spiel mit 1. Gruppe C -> 3 A
        // Spiel mit 1. Gruppe D -> 3 E

        // Spiel mit 1. Gruppe B -> 3 C
        // Spiel mit 1. Gruppe C -> 3 D
        // Spiel mit 1. Gruppe E -> 3 A
        // Spiel mit 1. Gruppe F -> 3 E

        for ($i = 0; $i < count($roundsForMatches); $i++) {
            $roundName = $roundsForMatches[$i];
            $roundNameOfThird = $combination[$i];
            $round = $this->groupRoundRepository->findOneByNameAndCup($roundNameOfThird, $cup);
            if ($round instanceof GroupRound === false) {
                throw new Exception('no round found with name '. $roundNameOfThird, 1464109834);
            }
            $match = $this->matchRepository->findOneByCupAndRoundName($cup, $roundName);
            if ($match instanceof CrossGroupWithThirdsMatch === false) {
                throw new Exception('no match found for group round ' . $roundName, 1464109833);
            }
            $team = $this->getTeamByRound($groupTableRows, $round);
            $match->setGuestTeam($team);
            $this->matchRepository->update($match);
        }

        return $groupTableRows;
    }

    public function finishOne(GroupRound $round)
    {
        $winnerTeam = $round->getWinnerTeam();
        $secondTeam = $round->getSecondTeam();

        $koMatch = $this->crossGroupMatchRepository->findOneInGroupRoundWithRank($round, 1);
        if ($koMatch instanceof KoMatch) {
            if ($koMatch->getHostGroupRank() === 1 && $koMatch->getHostGroupRound() === $round) {
                $koMatch->setHostTeam($winnerTeam);
            } elseif ($koMatch->getGuestGroupRank() === 1 && $koMatch->getGuestGroupRound() === $round) {
                $koMatch->setGuestTeam($winnerTeam);
            }
            $this->crossGroupMatchRepository->update($koMatch);
        }
        $otherKoMatch = $this->crossGroupMatchRepository->findOneInGroupRoundWithRank($round, 2);
        if ($otherKoMatch instanceof KoMatch) {
            if ($otherKoMatch->getGuestGroupRank() === 2 && $otherKoMatch->getGuestGroupRound() === $round) {
                $otherKoMatch->setGuestTeam($secondTeam);
            } elseif ($otherKoMatch->getHostGroupRank() === 2 && $otherKoMatch->getHostGroupRound() === $round) {
                $otherKoMatch->setHostTeam($secondTeam);
            }
            $this->crossGroupMatchRepository->update($otherKoMatch);
        }
    }

    /**
     * @param array $groupTableRows
     * @param GroupRound $groupRound
     * @return \AchimFritz\ChampionShip\Competition\Domain\Model\Team
     * @throws Exception
     */
    protected function getTeamByRound(array $groupTableRows, GroupRound $groupRound)
    {
        foreach ($groupTableRows as $groupTableRow) {
            if ($groupTableRow->getGroupRound() === $groupRound) {
                return $groupTableRow->getTeam();
            }
        }
        throw new Exception('no team found for groupround ' . $groupRound->getName(), 1464109834);
    }


    /**
     * @param $groupTableRows
     * @return void
     */
    protected function buildRoundsString($groupTableRows)
    {
        $rounds = array();
        foreach ($groupTableRows as $groupTableRow) {
            $rounds[] = $groupTableRow->getGroupRound()->getName();
        }
        sort($rounds);
        return implode('', $rounds);
    }

    /**
     * @param Cup $cup
     * @return array
     * @throws Exception
     */
    protected function buildGroupTableRows(Cup $cup)
    {
        $groupRounds = $this->groupRoundRepository->findByCup($cup);
        $groupTableRows = array();
        foreach ($groupRounds as $groupRound) {
            if ($groupRound->getRoundIsFinished() === false) {
                throw new Exception('groupRound not finished ' . $groupRound->getName(), 1464109831);
            }
            $groupTableRows[] = $groupRound->getGroupTableRowByRank(3);
        }
        $policy = $this->getPolicy();
        $groupTableRows = $policy->updateTable($groupTableRows);
        // 1-4
        $groupTableRows = array_slice($groupTableRows, 0, 4);
        return $groupTableRows;
    }

    /**
     * @return BestThirdsPolicy
     */
    protected function getPolicy()
    {
        return new BestThirdsPolicy();
    }
}
