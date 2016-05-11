<?php
namespace AchimFritz\ChampionShip\Tip\Domain\Repository;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use \TYPO3\Flow\Persistence\Repository;

/**
 * A repository for TipGroups
 *
 * @Flow\Scope("singleton")
 */
class TipCupRepository extends Repository {

	/**
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
		$this->setDefaultOrderings(array('cup.startDate' => \TYPO3\Flow\Persistence\QueryInterface::ORDER_ASCENDING));
	}

	/**
	 * @return \AchimFritz\ChampionShip\Tip\Domain\Model\TipCup
	 */
	public function findOneRecent() {
		$query = $this->createQuery();
		$query->setOrderings(array('cup.startDate' => \TYPO3\Flow\Persistence\QueryInterface::ORDER_DESCENDING));
		return $query->execute()->getFirst();
	}

}
