<?php
namespace AchimFritz\ChampionShip\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

use \AchimFritz\ChampionShip\Domain\Model\ChildKoRound;
use \AchimFritz\ChampionShip\Domain\Model\Cup;

/**
 * ChildKoRound controller for the AchimFritz.ChampionShip package 
 *
 * @Flow\Scope("singleton")
 */
class ChildKoRoundController extends RoundController {
	
	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\KoRoundRepository
	 */
	protected $roundRepository;
	
	/**
	 * createAction
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\ChildKoRound $round
	 * @return void
	 */
	public function createAction(ChildKoRound $round) {
		$this->createRound($round);
		$this->redirect('index', 'KoRound', NULL, array('cup' => $round->getCup(), 'round' => $round));
	}

	/**
	 * updateAction
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\ChildKoRound $round
	 * @return void
	 */
	public function updateAction(ChildKoRound $round) {
		$this->updateRound($round);
		$this->redirect('index', 'KoRound', NULL, array('cup' => $round->getCup(), 'round' => $round));
	}

	/**
	 * deleteAction
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\ChildKoRound $round
	 * @return void
	 */
	public function deleteAction(ChildKoRound $round) {
		$this->deleteRound($round);
		$this->redirect('index', 'KoRound', NULL, array('cup' => $round->getCup()));
	}
}

?>
