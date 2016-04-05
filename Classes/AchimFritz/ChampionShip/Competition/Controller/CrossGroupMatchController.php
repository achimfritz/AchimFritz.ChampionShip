<?php
namespace AchimFritz\ChampionShip\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

use \AchimFritz\ChampionShip\Domain\Model\Cup;
use \AchimFritz\ChampionShip\Domain\Model\CrossGroupMatch;

/**
 * Match controller for the AchimFritz.ChampionShip package 
 *
 * @Flow\Scope("singleton")
 */
class CrossGroupMatchController extends KoMatchController {
		
	/**
	 * Adds the given new match object to the cup repository
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\CrossGroupMatch $match
	 * @return void
	 */
	public function createAction(CrossGroupMatch $match) {
		$this->createMatch($match);
		$this->redirect('index', NULL, NULL, array('match' => $match, 'cup' => $match->getCup()));
	}

	/**
	 * deleteAction
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\CrossGroupMatch $match
	 * @return void
	 */
	public function deleteAction(CrossGroupMatch $match) {
		$this->deleteMatch($match);
		$this->redirect('index', 'KoRound', NULL, array('round' => $match->getRound(), 'cup' => $match->getCup()));
	}

	/**
	 * updateAction
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\CrossGroupMatch $match
	 * @return void
	 */
	public function updateAction(CrossGroupMatch $match) {
		$this->updateMatch($match);
		$this->redirect('index', NULL, NULL, array('match' => $match, 'cup' => $match->getCup()));
	}
}

?>
