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
	 * Adds the given new group round object to the group round repository
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\ChildKoRound $groupRound A new group round to add
	 * @return void
	 */
	public function createAction(ChildKoRound $round) {
		try {
			$this->roundRepository->add($round);
			$this->persistenceManager->persistAll();
			$this->addOkMessage('round created');
		} catch (\Exception $e) {
			$this->addErrorMessage('cannot create round');
			$this->handleException($e);
		}
		$this->redirect('index', 'KoRound', NULL, array('cup' => $round->getCup(), 'round' => $round));
	}
}

?>
