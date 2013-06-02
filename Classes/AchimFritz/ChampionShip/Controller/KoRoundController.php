<?php
namespace AchimFritz\ChampionShip\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

use \AchimFritz\ChampionShip\Domain\Model\KoRound;

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
	 * Shows a single ko round object
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\KoRound $koRound The ko round to show
	 * @return void
	 */
	public function showAction(KoRound $koRound) {
		$this->view->assign('koRound', $koRound);
	}

	/**
	 * Shows a form for creating a new group round object
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\Cup
	 * @return void
	 */
	public function newAction(\AchimFritz\ChampionShip\Domain\Model\Cup $cup) {
		$this->view->assign('cup', $cup);
	}

	/**
	 * Adds the given new ko round object to the ko round repository
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\KoRound $newKoRound A new ko round to add
	 * @return void
	 */
	public function createAction(KoRound $newKoRound) {
		try {
			$this->koRoundRepository->add($newKoRound);
			$this->persistenceManager->persistAll();
			$this->addOkMessage('round created');
		} catch (\Exception $e) {
			$this->addErrorMessage('cannot create round');
			$this->handleException($e);
		}
		$this->redirect('show', 'Cup', NULL, array('cup' => $newKoRound->getCup()));
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
		$this->redirect('show', 'Cup', NULL, array('cup' => $koRound->getCup()));
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
		$this->redirect('show', 'Cup', NULL, array('cup' => $koRound->getCup()));
	}

}

?>