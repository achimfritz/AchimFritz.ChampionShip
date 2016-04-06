<?php
namespace AchimFritz\ChampionShip\Competition\Domain\Repository;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Competition\Domain\Model\TeamsOfTwoMatchesMatch;
use AchimFritz\ChampionShip\Domain\Model\Result;

/**
 * A repository for Matches
 *
 * @Flow\Scope("singleton")
 */
class KoMatchRepository extends MatchRepository {

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\TeamsOfTwoMatchesMatchRepository
	 */
	protected $teamsOfTwoMatchesMatchRepository;

	/**
	 * remove 
	 * 
	 * @param mixed $object 
	 * @return void
	 */
	public function remove($object) {
		$hostMatch = $this->teamsOfTwoMatchesMatchRepository->findOneByHostMatch($object);
		if ($hostMatch instanceof TeamsOfTwoMatchesMatch) {
			$this->remove($hostMatch);
		}
		$guestMatch = $this->teamsOfTwoMatchesMatchRepository->findOneByGuestMatch($object);
		if ($guestMatch instanceof TeamsOfTwoMatchesMatch) {
			$this->remove($guestMatch);
		}
		parent::remove($object);
	}

	/**
	 * update 
	 * 
	 * @param mixed $object 
	 * @return void
	 */
	public function update($object) {
		if ($object->getResult() instanceof Result) {
			$winnerTeam = $object->getWinnerTeam();
			$looserTeam = $object->getLooserTeam();
			if ($winnerTeam !== NULL) {
				// hostTeam
				$koMatch = $this->teamsOfTwoMatchesMatchRepository->findOneByHostMatchAndWinner($object, TRUE);
				if ($koMatch instanceof TeamsOfTwoMatchesMatch) {
					$koMatch->setHostTeam($winnerTeam);
					$this->teamsOfTwoMatchesMatchRepository->update($koMatch);
				} 
				$koMatch = $this->teamsOfTwoMatchesMatchRepository->findOneByHostMatchAndWinner($object, FALSE);
				if ($koMatch instanceof TeamsOfTwoMatchesMatch) {
					$koMatch->setHostTeam($looserTeam);
					$this->teamsOfTwoMatchesMatchRepository->update($koMatch);
				}

				// guestTeam
				$koMatch = $this->teamsOfTwoMatchesMatchRepository->findOneByGuestMatchAndWinner($object, TRUE);
				if ($koMatch instanceof TeamsOfTwoMatchesMatch) {
					$koMatch->setGuestTeam($winnerTeam);
					$this->teamsOfTwoMatchesMatchRepository->update($koMatch);
				}
				$koMatch = $this->teamsOfTwoMatchesMatchRepository->findOneByGuestMatchAndWinner($object, FALSE);
				if ($koMatch instanceof TeamsOfTwoMatchesMatch) {
					$koMatch->setGuestTeam($looserTeam);
					$this->teamsOfTwoMatchesMatchRepository->update($koMatch);
				}
			}
		}

		parent::update($object);
	}
}
?>
