<?php
namespace AchimFritz\ChampionShip\Command;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use \AchimFritz\ChampionShip\Domain\Model\Cup;
use \AchimFritz\ChampionShip\Domain\Model\Ranking;

/**
 * Point Command
 *
 * @Flow\Scope("singleton")
 */
class RankingCommandController extends \TYPO3\Flow\Cli\CommandController {
	
	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\CupRepository
	 */
	protected $cupRepository;
	
	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Service\RankingCalculator
	 */
	protected $rankingCalculator;
	
	/**
	 * updateCommand 
	 * 
	 * @param string $cupName 
	 * @return void
	 */
	public function updateCommand($cupName) {
		$cup = $this->cupRepository->findOneByName($cupName);
		if (!$cup instanceof Cup) {
			$this->outputLine('no cup found with name ' . $cupName);
			$this->quit();
		}
		$rankings = $this->rankingCalculator->updateCup($cup);
		foreach ($rankings AS $ranking) {
			$this->outputLine($ranking->getUser()->getName() . ' ' . $ranking->getPoints());
		}
	}
}

?>
