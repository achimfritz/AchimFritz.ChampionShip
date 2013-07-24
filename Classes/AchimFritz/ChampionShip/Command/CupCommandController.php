<?php
namespace AchimFritz\ChampionShip\Command;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use \AchimFritz\ChampionShip\Domain\Model\Cup;

/**
 * Cup Command Controller for the AchimFritz.ChampionShip package
 *
 * @Flow\Scope("singleton")
 */
class CupCommandController extends \TYPO3\Flow\Cli\CommandController {
	
	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\CupRepository
	 */
	protected $cupRepository;
	
	/**
	 * list
	 *
	 * @return void
	 */
	public function listCommand() {
		#$cup = new Cup();
		#$cup->setName('test1');
		#$cup->setStartDate(new \DateTime());
		#$this->cupRepository->add($cup);
		$cups = $this->cupRepository->findAll();
		foreach ($cups AS $cup) {
			$this->outputLine($cup->getName());
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
	 * @param \AchimFritz\ChampionShip\Domain\Model\Cup $newCup A new cup to add
	 * @return void
	 */
	public function createCommand(Cup $cup) {
	}

}

?>
