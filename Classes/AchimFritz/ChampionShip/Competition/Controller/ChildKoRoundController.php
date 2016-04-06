<?php
namespace AchimFritz\ChampionShip\Competition\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

use \AchimFritz\ChampionShip\Competition\Domain\Model\ChildKoRound;

/**
 * ChildKoRound controller for the AchimFritz.ChampionShip package 
 *
 * @Flow\Scope("singleton")
 */
class ChildKoRoundController extends RoundController {
	
	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\KoRoundRepository
	 */
	protected $roundRepository;
	
	/**
	 * createAction
	 *
	 * @param \AchimFritz\ChampionShip\Competition\Domain\Model\ChildKoRound $round
	 * @return void
	 */
	public function createAction(ChildKoRound $round) {
		$this->createRound($round);
		$this->redirect('index', 'KoRound', NULL, array('cup' => $round->getCup(), 'round' => $round));
	}

	/**
	 * updateAction
	 *
	 * @param \AchimFritz\ChampionShip\Competition\Domain\Model\ChildKoRound $round
	 * @return void
	 */
	public function updateAction(ChildKoRound $round) {
		$this->updateRound($round);
		$this->redirect('index', 'KoRound', NULL, array('cup' => $round->getCup(), 'round' => $round));
	}

	/**
	 * deleteAction
	 *
	 * @param \AchimFritz\ChampionShip\Competition\Domain\Model\ChildKoRound $round
	 * @return void
	 */
	public function deleteAction(ChildKoRound $round) {
		$this->deleteRound($round);
		$this->redirect('index', 'KoRound', NULL, array('cup' => $round->getCup()));
	}
}

?>
