<?php
namespace AchimFritz\ChampionShip\Domain\Repository;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

/**
 * A repository for KoRounds
 *
 * @Flow\Scope("singleton")
 */
class KoRoundRepository extends RoundRepository {

	/**
	 * @var \AchimFritz\ChampionShip\Domain\Service\KoRoundService
	 * @Flow\Inject
	 */
	protected $koRoundService;

	/**
	 * update
	 * 
	 * @param object $object
	 */
	public function update($object) {
		$object = $this->koRoundService->updateGroup($object);
		return parent::update($object);
	}
	
	/**
	 * add
	 * 
	 * @param object $object
	 */
	public function add($object) {
		$object = $this->koRoundService->updateGroup($object);
		return parent::add($object);
	}

}
?>