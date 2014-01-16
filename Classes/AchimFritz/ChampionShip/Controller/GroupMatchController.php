<?php
namespace AchimFritz\ChampionShip\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

use \AchimFritz\ChampionShip\Domain\Model\GroupMatch;
use \AchimFritz\ChampionShip\Domain\Model\Cup;

/**
 * Match controller for the AchimFritz.ChampionShip package 
 *
 * @Flow\Scope("singleton")
 */
class GroupMatchController extends MatchController {
		
	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\GroupMatchRepository
	 */
	protected $matchRepository;

	/**
	 * Adds the given new match object to the cup repository
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\GroupMatch $match
	 * @return void
	 */
	public function createAction(GroupMatch $match) {
		$this->createMatch($match);
		$this->redirect('index', 'GroupRound', NULL, array('round' => $match->getRound(), 'cup' => $match->getCup()));
	}

	/**
	 * deleteAction
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\GroupMatch $match
	 * @return void
	 */
	public function deleteAction(GroupMatch $match) {
		$this->deleteMatch($match);
		$this->redirect('index', 'KoRound', NULL, array('round' => $match->getRound(), 'cup' => $match->getCup()));
	}

	/**
	 * updateAction
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\GroupMatch $match
	 * @return void
	 */
	public function updateAction(GroupMatch $match) {
		$this->updateMatch($match);
		$this->redirect('index', 'KoRound', NULL, array('round' => $match->getRound(), 'cup' => $match->getCup()));
	}
}

?>
