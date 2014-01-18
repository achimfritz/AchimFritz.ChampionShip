<?php
namespace AchimFritz\ChampionShip\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Mvc\Controller\RestController;
use TYPO3\Flow\Mvc\View\JsonView;

/**
 * Standard controller for the AchimFritz.ChampionShip package 
 *
 * @Flow\Scope("singleton")
 */
class StandardController extends ActionController {


	/**
	 * Index action
	 *
	 * @return void
	 */
	public function listAction() {
		$cup = $this->cupRepository->findOneRecent();
		$this->redirect('index', 'Cup', NULL, array('cup' => $cup));

	}

}

?>
