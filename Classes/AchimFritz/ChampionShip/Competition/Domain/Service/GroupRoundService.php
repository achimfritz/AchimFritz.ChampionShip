<?php
namespace AchimFritz\ChampionShip\Competition\Domain\Service;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use AchimFritz\ChampionShip\Competition\Domain\Model\CrossGroupWithThirdsMatch;
use AchimFritz\ChampionShip\Competition\Domain\Model\Cup;
use AchimFritz\ChampionShip\Competition\Domain\Model\GroupRound;
use AchimFritz\ChampionShip\Competition\Domain\Policy\GroupTable\BestThirdsPolicy;
use TYPO3\Flow\Annotations as Flow;

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
        $roundMatrix = $policy->getRoundMatrix();
        if (empty($roundMatrix[$roundString]) === true) {
            throw new Exception('no matrix round found for ' . $roundString, 1464109832);
        }
        $combination = $roundMatrix[$roundString];
        $roundsForMatches = $this->getPolicy()->getOrderRoundsForMatches();
        // string by alpha sort -> A C D E
        // A C D E         C       D       A       E
        // Spiel mit 1. Gruppe A -> 3 C
        // Spiel mit 1. Gruppe B -> 3 D
        // Spiel mit 1. Gruppe C -> 3 A
        // Spiel mit 1. Gruppe D -> 3 E
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
