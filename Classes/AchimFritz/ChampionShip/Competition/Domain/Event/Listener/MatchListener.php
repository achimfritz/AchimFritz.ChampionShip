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
     * @var \AchimFritz\ChampionShip\Competition\Domain\Service\GroupRoundService
     */
    protected $groupRoundService;

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
        $round->updateGroupTable();

        if ($round->getRoundIsFinished() === true) {
            $this->groupRoundService->finishOne($round);
        }
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
