<?php
namespace AchimFritz\ChampionShip\Domain\Repository;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Domain\Model\GroupRound;

/**
 * A repository for Matches
 *
 * @Flow\Scope("singleton")
 */
class GroupMatchRepository extends MatchRepository {

	/**
	 * @var \AchimFritz\ChampionShip\Domain\Service\GroupRoundService
	 * @Flow\Inject
	 */
	protected $groupRoundService;

	/**
	 * update 
	 * 
	 * @param mixed $object 
	 * @return void
	 */
	public function update($object) {
		if ($object->getResult() instanceof Result) {
			$group = $this->groupRoundService->updateGroupTable($object->getGroup());
		}
		parent::update($group);
	}

	
}
?>
