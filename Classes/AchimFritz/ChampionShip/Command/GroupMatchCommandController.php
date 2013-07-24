<?php
namespace AchimFritz\ChampionShip\Command;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use \AchimFritz\ChampionShip\Domain\Model\Cup;
use \AchimFritz\ChampionShip\Domain\Model\GroupMatch;

/**
 * GroupMatch Command Controller for the AchimFritz.ChampionShip package
 *
 * @Flow\Scope("singleton")
 */
class GroupMatchCommandController extends \TYPO3\Flow\Cli\CommandController {
	
	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\CupRepository
	 */
	protected $cupRepository;

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\GroupMatchRepository
	 */
	protected $groupMatchRepository;
	
	/**
	 * list
	 *
	 * @return void
	 */
	public function listCommand() {
		#$cup = $this->cupRepository->findOneByName('test35');
		$groupMatch = new GroupMatch();
		$groupMatch->setName('test1');
		#$groupMatch->setStartDate(new \DateTime());
		$this->groupMatchRepository->add($groupMatch);
		$groupMatchs = $this->groupMatchRepository->findAll();
		foreach ($groupMatchs AS $groupMatch) {
			$this->outputLine($groupMatch->getName());
		}
	}

	/**
	 * update
	 *
	 * @return void
	 */
	public function updateCommand() {
	}
	
	/**
	 * clean
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\GroupMatch $newGroupMatch A new groupMatch to add
	 * @return void
	 */
	public function createCommand(GroupMatch $groupMatch) {
	}

}

?>
