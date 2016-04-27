<?php
namespace AchimFritz\ChampionShip\Tip\Domain\Repository;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Tip\Domain\Model\Cup;
use TYPO3\Flow\Persistence\QueryInterface;

/**
 * @Flow\Scope("singleton")
 */
class CupRankingRepository extends AbstractRankingRepository {


	/**
	 * @param \TYPO3\Flow\Persistence\QueryResultInterface|array $users
	 * @param Cup $cup
	 * @return \TYPO3\Flow\Persistence\QueryResultInterface
	 */
	public function findByUsersAndCup($users, Cup $cup) {
		$identifiers = array();
		foreach ($users as $user) {
			$identifiers[] = $this->persistenceManager->getIdentifierByObject($user);
		}
		$query = $this->createQuery();
		return $query->matching(
			$query->logicalAnd(
				$query->in('user', $identifiers),
				$query->equals('cup', $cup)
				)
			)
		->execute();
	}

}
