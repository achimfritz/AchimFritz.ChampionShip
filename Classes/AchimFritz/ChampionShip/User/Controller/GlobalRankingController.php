<?php
namespace AchimFritz\ChampionShip\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

use AchimFritz\ChampionShip\Domain\Model\Ranking;
use AchimFritz\ChampionShip\Competition\Domain\Model\Cup;
use AchimFritz\ChampionShip\Domain\Model\TipGroup;

/**
 * Team controller for the AchimFritz.ChampionShip package 
 *
 * @Flow\Scope("singleton")
 */
class GlobalRankingController extends AbstractRankingController {

	/**
	 * listAction 
	 * 
	 * @return void
	 */
	public function listAction() {
		$matches = $this->matchRepository->findAll();
		$rankings = $this->rankingsFactory->create($matches);
		$this->view->assign('rankings', $rankings);
	}

	/**
	 * Shows a list of rankings
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\TipGroup $tipGroup
	 * @return void
	 */
	public function showAction(TipGroup $tipGroup) {
		$matches = $this->matchRepository->findAll();
		$rankings = $this->rankingsFactory->create($matches, $tipGroup);
		$this->view->assign('rankings', $rankings);
		$this->view->assign('tipGroup', $tipGroup);
	}

}

?>
