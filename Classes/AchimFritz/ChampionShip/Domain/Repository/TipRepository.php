<?php
namespace AchimFritz\ChampionShip\Domain\Repository;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Domain\Model\User;
use \TYPO3\Flow\Persistence\QueryInterface;

/**
 * A repository for TipGroups
 *
 * @Flow\Scope("singleton")
 */
class TipRepository extends \TYPO3\Flow\Persistence\Repository {

	/**
	 * findByUser 
	 * 
	 * @param User $user 
	 * @return \TYPO3\FLOW3\Persistence\QueryResultInterface
	 */
	public function findByUser(User $user) {
		$query = $this->createQuery();
		return $query->matching(
			$query->contains('users', $user)
		)
		->execute();
	}

}
?>
