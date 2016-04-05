<?php
namespace AchimFritz\ChampionShip\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

use \AchimFritz\ChampionShip\Domain\Model\GroupRound;
use \AchimFritz\ChampionShip\Domain\Model\Cup;

/**
 * GroupRound controller for the AchimFritz.ChampionShip package 
 *
 * @Flow\Scope("singleton")
 */
class GroupRoundController extends RoundController {

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\GroupRoundRepository
	 */
	protected $roundRepository;
	

	/**
	 * createAction
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\GroupRound $round
	 * @return void
	 */
	public function createAction(GroupRound $round) {
		$this->createRound($round);
		$this->redirect('index', NULL, NULL, array('cup' => $round->getCup(), 'round' => $round));
	}

	/**
	 * updateAction
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\GroupRound $round
	 * @return void
	 */
	public function updateAction(GroupRound $round) {
		$this->updateRound($round);
		$this->redirect('index', NULL, NULL, array('cup' => $round->getCup(), 'round' => $round));
	}

	/**
	 * deleteAction
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\GroupRound $round
	 * @return void
	 */
	public function deleteAction(GroupRound $round) {
		$this->deleteRound($round);
		$this->redirect('index', NULL, NULL, array('cup' => $round->getCup()));
	}


}

?>
