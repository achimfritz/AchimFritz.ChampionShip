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
class KoRoundController extends ActionController {

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\KoRoundRepository
	 */
	protected $koRoundRepository;
	
	/**
	 * @var \AchimFritz\ChampionShip\Domain\Service\KoRoundService
	 * @Flow\Inject
	 */
	protected $koRoundService;

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\GroupRoundRepository
	 */
	protected $groupRoundRepository;
	
	/**
	 * listAction
	 * 
	 * @param \AchimFritz\ChampionShip\Domain\Model\Cup $cup
	 */
	public function listAction(Cup $cup) {
		$koRounds = $this->koRoundRepository->findByCup($cup);
		$this->view->assign('koRounds', $koRounds);
	}


	/**
	 * Adds the given new ko round object to the ko round repository
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\Cup
	 * @return void
	 */
	public function createAction(Cup $cup) {
		try {
			$groupRounds = $this->groupRoundRepository->findByCup($cup);
			$koRounds = $this->koRoundService->createKoRounds($groupRounds);
			foreach ($koRounds AS $koRound) {
				$this->koRoundRepository->add($koRound);
			}
			$this->persistenceManager->persistAll();
			$this->addOkMessage('koRounds created');
		} catch (\Exception $e) {
			$this->handleException($e);	
		}
		$this->redirect('list', 'KoRound', NULL, array('cup' => $cup));
	}

	/**
	 * Shows a form for editing an existing ko round object
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\KoRound $koRound The ko round to edit
	 * @return void
	 */
	public function editAction(KoRound $koRound) {
		$this->view->assign('koRound', $koRound);
	}

	/**
	 * Updates the given ko round object
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\KoRound $koRound The ko round to update
	 * @return void
	 */
	public function updateAction(KoRound $koRound) {
		try {
			$this->koRoundRepository->update($koRound);
			$this->persistenceManager->persistAll();
			$this->addOkMessage('round updatet');
		} catch (\Exception $e) {
			$this->addErrorMessage('cannot update round');
			$this->handleException($e);
		}
		$this->redirect('list', 'KoRound', NULL, array('cup' => $cup));
	}

	/**
	 * Removes the given ko round object from the ko round repository
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\KoRound $koRound The ko round to delete
	 * @return void
	 */
	public function deleteAction(KoRound $koRound) {
		try {
			$this->koRoundRepository->remove($koRound);
			$this->persistenceManager->persistAll();
			$this->addOkMessage('round deletet');
		} catch (\Exception $e) {
			$this->addErrorMessage('cannot delete round');
			$this->handleException($e);
		}
		$this->redirect('list', 'KoRound', NULL, array('cup' => $cup));
	}

}

?>