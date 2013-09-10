<?php
namespace AchimFritz\ChampionShip\Domain\Repository;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Domain\Model\Cup;

/**
 * A repository for KoRounds
 *
 * @Flow\Scope("singleton")
 */
class RoundRepository extends \TYPO3\Flow\Persistence\Repository {

	
	/**
	 * findOneByNameAndCup
	 * 
	 * @param string $name
	 * @param Cup $cup
	 * @return \TYPO3\FLOW3\Persistence\QueryResultInterface
	 */
	public function findOneByNameAndCup($name, Cup $cup) {
		$query = $this->createQuery();
		return $query->matching(
            $query->logicalAnd(
				$query->equals('name', $name),
				$query->equals('cup', $cup)
			)
		)
		->execute()->getFirst();
	}

}
?>
