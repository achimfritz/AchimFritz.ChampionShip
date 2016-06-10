<?php
namespace AchimFritz\ChampionShip\Competition\Domain\Repository;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

/**
 * A repository for Teams
 *
 * @Flow\Scope("singleton")
 */
class TeamRepository extends \TYPO3\Flow\Persistence\Repository {

	/**
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
		$this->setDefaultOrderings(array('name' => \TYPO3\Flow\Persistence\QueryInterface::ORDER_ASCENDING));
	}

}
