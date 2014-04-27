<?php
namespace AchimFritz\ChampionShip\Domain\Repository;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Domain\Model\TeamsOfTwoMatchesMatch;

/**
 * A repository for Matches
 *
 * @Flow\Scope("singleton")
 */
class KoMatchRepository extends MatchRepository {

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\TeamsOfTwoMatchesMatchRepository
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
}
?>
