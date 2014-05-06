<?php
namespace AchimFritz\ChampionShip\Domain\Repository;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Domain\Model\TeamsOfTwoMatchesMatch;
use AchimFritz\ChampionShip\Domain\Model\KoMatch;

/**
 * A repository for Matches
 *
 * @Flow\Scope("singleton")
 */
class TeamsOfTwoMatchesMatchRepository extends KoMatchRepository {

	/**
	 * findOneByHostMatchAndWinner 
	 * 
	 * @param KoMatch $match 
	 * @param boolean $isWinner 
	 * @return TeamsOfTwoMatchesMatch|NULL
	 */
	public function findOneByHostMatchAndWinner(KoMatch $match, $isWinner) {
		$query = $this->createQuery();
		return $query->matching(
				$query->logicalAnd(
					$query->equals('hostMatch', $match),
					$query->equals('hostMatchIsWinner', $isWinner)
					)
				)
			->execute()->getFirst();
	}

	/**
	 * findOneByGuestMatchAndWinner 
	 * 
	 * @param KoMatch $match 
	 * @param boolean $isWinner 
	 * @return TeamsOfTwoMatchesMatch|NULL
	 */
	public function findOneByGuestMatchAndWinner(KoMatch $match, $isWinner) {
		$query = $this->createQuery();
		return $query->matching(
				$query->logicalAnd(
					$query->equals('guestMatch', $match),
					$query->equals('guestMatchIsWinner', $isWinner)
					)
				)
			->execute()->getFirst();
	}

}
?>
