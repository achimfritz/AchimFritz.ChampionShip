<?php
namespace AchimFritz\ChampionShip\Competition\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

use \AchimFritz\ChampionShip\Competition\Domain\Model\Round;
use \AchimFritz\ChampionShip\Competition\Domain\Model\Cup;

/**
 * GroupRound controller for the AchimFritz.ChampionShip package 
 *
 * @Flow\Scope("singleton")
 */
class RoundController extends \AchimFritz\ChampionShip\Controller\AbstractActionController {

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\RoundRepository
	 */
	protected $roundRepository;
	
	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\GroupRoundRepository
	 */
	protected $groupRoundRepository;
	
	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\KoRoundRepository
	 */
	protected $koRoundRepository;
	
	/**
	 * @var string
	 */
	protected $resourceArgumentName = 'round';

	/**
	 * listAction
	 * 
	 * @return void
	 */
	public function listAction() {
		if ($this->cup instanceof Cup) {
			$round = $this->roundRepository->findOneByCup($this->cup);
			if ($round instanceof Round) {
				$this->forward('show', NULL, NULL, array('round' => $round, 'cup' => $round->getCup()));
			} else {
				$this->view->assign('allGroupRounds', $this->groupRoundRepository->findByCup($this->cup));
				$this->addErrorMessage('no rounds found');
			}
		} else {
				$this->addErrorMessage('no cup');
		}
	}

	/**
	 * showAction
	 * 
	 * @param \AchimFritz\ChampionShip\Competition\Domain\Model\Round $round
	 */
	public function showAction(Round $round) {
      $cup = $round->getCup();
		$this->view->assign('cup', $cup);
		$this->view->assign('round', $round);
      $this->view->assign('allKoRounds', $this->koRoundRepository->findByCup($cup));
      $this->view->assign('allGroupRounds', $this->groupRoundRepository->findByCup($cup));
	}

	/**
	 * Adds the given new group round object to the group round repository
	 *
	 * @param \AchimFritz\ChampionShip\Competition\Domain\Model\Round $round
	 * @return void
	 */
	protected function createRound(Round $round) {
		try {
			$this->roundRepository->add($round);
			$this->persistenceManager->persistAll();
			$this->addOkMessage('round created');
		} catch (\Exception $e) {
			$this->addErrorMessage('cannot create round');
			$this->handleException($e);
		}
	}

	/**
	 * Updates the given group round object
	 *
	 * @param \AchimFritz\ChampionShip\Competition\Domain\Model\Round $round The group round to update
	 * @return void
	 */
	protected function updateRound(Round $round) {
		try {
			$this->roundRepository->update($round);
			$this->persistenceManager->persistAll();
			$this->addOkMessage('round updated');
		} catch (\Exception $e) {
			$this->addErrorMessage('cannot update round');
			$this->handleException($e);
		}
	}

	/**
	 * Removes the given group round object from the group round repository
	 *
	 * @param \AchimFritz\ChampionShip\Competition\Domain\Model\Round $round The group round to delete
	 * @return void
	 */
	protected function deleteRound(Round $round) {
		$cup = $round->getCup();
		try {
			$this->roundRepository->remove($round);
			$this->persistenceManager->persistAll();
			$this->addOkMessage('round deletet');
		} catch (\Exception $e) {
			$this->addErrorMessage('cannot delete round');
			$this->handleException($e);
		}
	}

}

?>
