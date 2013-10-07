<?php
namespace AchimFritz\ChampionShip\Domain\Repository;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Domain\Model\User;
use AchimFritz\ChampionShip\Domain\Model\Cup;
use AchimFritz\ChampionShip\Domain\Model\Ranking;

/**
 * RankingRepository
 *
 * @Flow\Scope("singleton")
 */
class RankingRepository extends \TYPO3\Flow\Persistence\Repository {

	/**
	 * findOneByUserInCup 
	 * 
	 * @param User $user 
	 * @param Cup $cup 
	 * @return Ranking|NULL
	 */
	public function findOneByUserInCup(User $user, Cup $cup) {
		$query = $this->createQuery();
		return $query->matching(
            $query->logicalAnd(
				$query->equals('user', $user),
				$query->equals('cup', $cup)
			)
		)
		->execute()->getFirst();
	}


}
?>
