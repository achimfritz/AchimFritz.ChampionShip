<?php
namespace AchimFritz\ChampionShip\Domain\Repository;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use \TYPO3\Flow\Persistence\QueryInterface;

/**
 * A repository for GroupRounds
 *
 * @Flow\Scope("singleton")
 */
class GroupRoundRepository extends RoundRepository {
	
	/**
	 * __construct 
	 * 
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
		$this->setDefaultOrderings(array('name' => QueryInterface::ORDER_ASCENDING));
	}


}
?>
