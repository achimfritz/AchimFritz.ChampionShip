<?php
namespace AchimFritz\ChampionShip\Domain\Repository;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Domain\Model\GroupRound;
use AchimFritz\ChampionShip\Domain\Model\Result;

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
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\GroupRoundRepository
	 */
	protected $roundRepository;

	/**
	 * update 
	 * 
	 * @param mixed $object 
	 * @return void
	 */
	public function update($object) {
		if ($object->getResult() instanceof Result) {
			$groupRound = $this->groupRoundService->updateGroupTable($object->getRound());
			$this->roundRepository->update($groupRound);
			// TODO
			/*
			if ($object->getRound()->getRoundIsFinished() === TRUE) {
				updateCrossGroupRoundMatch
				
			}
			*/
		}
		parent::update($object);
	}

	
}
?>
