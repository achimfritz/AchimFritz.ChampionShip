<?php
namespace AchimFritz\ChampionShip\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

use \AchimFritz\ChampionShip\Domain\Model\KoRound;
use \AchimFritz\ChampionShip\Domain\Model\Cup;

/**
 * KoRound controller for the AchimFritz.ChampionShip package 
 *
 * @Flow\Scope("singleton")
 */
class KoRoundController extends RoundController {

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\KoRoundRepository
	 */
	protected $roundRepository;
	
	/**
	 * createAction
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\KoRound $round
	 * @return void
	 */
	public function createAction(KoRound $round) {
		$this->createRound($round);
		$this->redirect('index', NULL, NULL, array('cup' => $round->getCup(), 'round' => $round));
	}

	/**
	 * updateAction
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\KoRound $round
	 * @return void
	 */
	public function updateAction(KoRound $round) {
		$this->updateRound($round);
		$this->redirect('index', NULL, NULL, array('cup' => $round->getCup(), 'round' => $round));
	}

	/**
	 * deleteAction
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\KoRound $round
	 * @return void
	 */
	public function deleteAction(KoRound $round) {
		$this->deleteRound($round);
		$this->redirect('index', NULL, NULL, array('cup' => $round->getCup()));
	}
}

?>
