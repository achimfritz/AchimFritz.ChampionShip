<?php
namespace AchimFritz\ChampionShip\Domain\Repository;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

/**
 * A repository for Cups
 *
 * @Flow\Scope("singleton")
 */
class CupRepository extends \TYPO3\Flow\Persistence\Repository {

   /**
    * findOneActual 
    * 
    * @return \AchimFritz\ChampionShip\Domain\Model\Cup
    */
	public function findOneRecent() {
		$query = $this->createQuery();
		$query->setOrderings(array('startDate' => \TYPO3\Flow\Persistence\QueryInterface::ORDER_DESCENDING));
		return $query->execute()->getFirst();
	}

}
?>
