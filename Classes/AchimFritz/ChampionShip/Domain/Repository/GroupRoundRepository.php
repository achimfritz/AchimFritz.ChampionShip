<?php
namespace AchimFritz\ChampionShip\Domain\Repository;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

/**
 * A repository for GroupRounds
 *
 * @Flow\Scope("singleton")
 */
class GroupRoundRepository extends RoundRepository {
	
	/**
	 * @var \AchimFritz\ChampionShip\Domain\Service\GroupRoundCalculatorService
	 * @Flow\Inject
	 */
	protected $groupRoundCalculatorService;

	/**
	 * update
	 * 
	 * @param object $object
	 */
	public function update($object) {
		$object = $this->groupRoundCalculatorService->updateGroup($object);
		return parent::update($object);
	}
	
	/**
	 * add
	 * 
	 * @param object $object
	 */
	public function add($object) {
		$object = $this->groupRoundCalculatorService->updateGroup($object);
		return parent::add($object);
	}

}
?>