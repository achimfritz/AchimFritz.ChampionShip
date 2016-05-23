<?php
namespace AchimFritz\ChampionShip\Competition\Domain\Event\Listener;


use AchimFritz\ChampionShip\Competition\Domain\Model\Match;
use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Competition\Domain\Model\KoMatch;
use AchimFritz\ChampionShip\Competition\Domain\Model\CrossGroupMatch;
use AchimFritz\ChampionShip\Competition\Domain\Model\GroupMatch;
use AchimFritz\ChampionShip\Competition\Domain\Model\TeamsOfTwoMatchesMatch;

/**
 * @Flow\Scope("singleton")
 */
class MatchListener {

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
	public function onMatchChanged(Match $match) {
		if ($match instanceof GroupMatch) {
			$this->onGroupMatchChanged($match);
		} elseif ($match instanceof KoMatch) {
			$this->onKoMatchChanged($match);
			if ($match instanceof CrossGroupMatch) {
				$this->onCrossGroupMatchChanged($match);
			}
		}
	}

	/**
	 * @param Match $match
	 * @return void
	 */
	public function onMatchRemoved(Match $match) {
		if ($match instanceof KoMatch) {
			$this->onKoMatchRemoved($match);
		}
	}

	/**
	 * @param KoMatch $match
	 * @return void
	 */
	protected function onKoMatchRemoved(KoMatch $match) {
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
	protected function onGroupMatchChanged(GroupMatch $match) {
		$round = $match->getRound();
		$round->updateGroupTable();
		$this->roundRepository->update($round);

		if ($round->getRoundIsFinished() === TRUE) {
			$winnerTeam = $round->getWinnerTeam();
			$secondTeam = $round->getSecondTeam();
			$koMatch = $this->crossGroupMatchRepository->findOneInGroupRoundWithRank($round, 1);
			if ($koMatch instanceof KoMatch) {
				if ($koMatch->getHostGroupRank() === 1) {
					$koMatch->setHostTeam($winnerTeam);
				} elseif ($koMatch->getGuestGroupRank() === 1) {
					$koMatch->setGuestTeam($winnerTeam);
				}
				$this->crossGroupMatchRepository->update($koMatch);
			}
			$otherKoMatch = $this->crossGroupMatchRepository->findOneInGroupRoundWithRank($round, 2);
			if ($otherKoMatch instanceof KoMatch) {
				if ($otherKoMatch->getGuestGroupRank() === 2) {
					$otherKoMatch->setGuestTeam($secondTeam);
				} elseif ($otherKoMatch->getHostGroupRank() === 2) {
					$otherKoMatch->setHostTeam($secondTeam);
				}
				$this->crossGroupMatchRepository->update($otherKoMatch);
			}
		}
	}

	/**
	 * @param CrossGroupMatch $match
	 * @return void
	 */
	protected function onCrossGroupMatchChanged(CrossGroupMatch $match) {
		$hostGroupRound = $match->getHostGroupRound();
		$guestGroupRound = $match->getGuestGroupRound();
		if ($hostGroupRound->getRoundIsFinished() === TRUE) {
			if ($match->getHostGroupRank() === 1) {
				$match->setHostTeam($hostGroupRound->getWinnerTeam());
			} elseif ($match->getHostGroupRank() === 2) {
				$match->setHostTeam($hostGroupRound->getSecondTeam());
			}
		}
		if ($guestGroupRound !== NULL && $guestGroupRound->getRoundIsFinished() === TRUE) {
			if ($match->getGuestGroupRank() === 1) {
				$match->setGuestTeam($guestGroupRound->getWinnerTeam());
			} elseif ($match->getGuestGroupRank() === 2) {
				$match->setGuestTeam($guestGroupRound->getSecondTeam());
			}
		}
	}

	/**
	 * @param KoMatch $match
	 * @return void
	 */
	protected function onKoMatchChanged(KoMatch $match) {
		$winnerTeam = $match->getWinnerTeam();
		$looserTeam = $match->getLooserTeam();
		if ($winnerTeam !== NULL) {
			// hostTeam
			$koMatch = $this->teamsOfTwoMatchesMatchRepository->findOneByHostMatchAndWinner($match, TRUE);
			if ($koMatch instanceof TeamsOfTwoMatchesMatch) {
				$koMatch->setHostTeam($winnerTeam);
				$this->teamsOfTwoMatchesMatchRepository->update($koMatch);
			}
			$koMatch = $this->teamsOfTwoMatchesMatchRepository->findOneByHostMatchAndWinner($match, FALSE);
			if ($koMatch instanceof TeamsOfTwoMatchesMatch) {
				$koMatch->setHostTeam($looserTeam);
				$this->teamsOfTwoMatchesMatchRepository->update($koMatch);
			}

			// guestTeam
			$koMatch = $this->teamsOfTwoMatchesMatchRepository->findOneByGuestMatchAndWinner($match, TRUE);
			if ($koMatch instanceof TeamsOfTwoMatchesMatch) {
				$koMatch->setGuestTeam($winnerTeam);
				$this->teamsOfTwoMatchesMatchRepository->update($koMatch);
			}
			$koMatch = $this->teamsOfTwoMatchesMatchRepository->findOneByGuestMatchAndWinner($match, FALSE);
			if ($koMatch instanceof TeamsOfTwoMatchesMatch) {
				$koMatch->setGuestTeam($looserTeam);
				$this->teamsOfTwoMatchesMatchRepository->update($koMatch);
			}
		}
	}

}

