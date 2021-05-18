<?php
namespace AchimFritz\ChampionShip\Competition\Domain\Event\Listener;

use AchimFritz\ChampionShip\Competition\Domain\Model\Match;
use Neos\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Competition\Domain\Model\KoMatch;
use AchimFritz\ChampionShip\Competition\Domain\Model\CrossGroupMatch;
use AchimFritz\ChampionShip\Competition\Domain\Model\GroupMatch;
use AchimFritz\ChampionShip\Competition\Domain\Model\TeamsOfTwoMatchesMatch;

/**
 * @Flow\Scope("singleton")
 */
class MatchListener
{

    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\TeamsOfTwoMatchesMatchRepository
     */
    protected $teamsOfTwoMatchesMatchRepository;

    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\GroupRoundRepository
     */
    protected $groupRoundRepository;

    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\GroupRoundRepository
     */
    protected $roundRepository;


    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\CrossGroupMatchRepository
     */
    protected $crossGroupMatchRepository;

    /**
     * @param Match $match
     * @return void
     */
    public function onMatchChanged(Match $match)
    {
        if ($match instanceof GroupMatch) {
            $this->onGroupMatchChanged($match);
        } elseif ($match instanceof KoMatch) {
            $this->onKoMatchChanged($match);
        }
    }

    /**
     * @param Match $match
     * @return void
     */
    public function onMatchRemoved(Match $match)
    {
        if ($match instanceof KoMatch) {
            $this->onKoMatchRemoved($match);
        }
    }

    /**
     * @param KoMatch $match
     * @return void
     */
    protected function onKoMatchRemoved(KoMatch $match)
    {
        $hostMatch = $this->teamsOfTwoMatchesMatchRepository->findOneByHostMatch($match);
        if ($hostMatch instanceof TeamsOfTwoMatchesMatch) {
            $this->teamsOfTwoMatchesMatchRepository->remove($hostMatch);
        }
        $guestMatch = $this->teamsOfTwoMatchesMatchRepository->findOneByGuestMatch($match);
        if ($guestMatch instanceof TeamsOfTwoMatchesMatch) {
            $this->teamsOfTwoMatchesMatchRepository->remove($guestMatch);
        }
    }

    /**
     * @param GroupMatch $match
     * @return void
     */
    protected function onGroupMatchChanged(GroupMatch $match)
    {
        $round = $match->getRound();

        if ($round->getRoundIsFinished() === true) {
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
        $round->updateGroupTable();
        $this->roundRepository->update($round);
    }

    /**
     * @param KoMatch $match
     * @return void
     */
    protected function onKoMatchChanged(KoMatch $match)
    {
        $winnerTeam = $match->getWinnerTeam();
        $looserTeam = $match->getLooserTeam();
        if ($winnerTeam !== null) {
            // hostTeam
            $koMatch = $this->teamsOfTwoMatchesMatchRepository->findOneByHostMatchAndWinner($match, true);
            if ($koMatch instanceof TeamsOfTwoMatchesMatch) {
                $koMatch->setHostTeam($winnerTeam);
                $this->teamsOfTwoMatchesMatchRepository->update($koMatch);
            }
            $koMatch = $this->teamsOfTwoMatchesMatchRepository->findOneByHostMatchAndWinner($match, false);
            if ($koMatch instanceof TeamsOfTwoMatchesMatch) {
                $koMatch->setHostTeam($looserTeam);
                $this->teamsOfTwoMatchesMatchRepository->update($koMatch);
            }

            // guestTeam
            $koMatch = $this->teamsOfTwoMatchesMatchRepository->findOneByGuestMatchAndWinner($match, true);
            if ($koMatch instanceof TeamsOfTwoMatchesMatch) {
                $koMatch->setGuestTeam($winnerTeam);
                $this->teamsOfTwoMatchesMatchRepository->update($koMatch);
            }
            $koMatch = $this->teamsOfTwoMatchesMatchRepository->findOneByGuestMatchAndWinner($match, false);
            if ($koMatch instanceof TeamsOfTwoMatchesMatch) {
                $koMatch->setGuestTeam($looserTeam);
                $this->teamsOfTwoMatchesMatchRepository->update($koMatch);
            }
        }
    }
}
