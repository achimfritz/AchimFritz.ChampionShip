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
	 * @var \AchimFritz\ChampionShip\Domain\Service\GroupRoundService
	 * @Flow\Inject
	 */
	protected $groupRoundService;

	/**
	 * update
	 * 
	 * @param object $object
	 */
	public function update($object) {
		$object = $this->groupRoundService->updateGroup($object);
		return parent::update($object);
	}
	
	/**
	 * add
	 * 
	 * @param object $object
	 */
	public function add($object) {
		$object = $this->groupRoundService->updateGroup($object);
		return parent::add($object);
	}

}
?>