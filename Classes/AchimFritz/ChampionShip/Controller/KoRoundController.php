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
	 * Shows a form for creating a new ko round object
	 *
	 * @return void
	 */
	public function newAction() {
	}

	/**
	 * Adds the given new ko round object to the ko round repository
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\KoRound $newKoRound A new ko round to add
	 * @return void
	 */
	public function createAction(KoRound $newKoRound) {
		$this->koRoundRepository->add($newKoRound);
		$this->addFlashMessage('Created a new ko round.');
		$this->redirect('index');
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
		$this->koRoundRepository->update($koRound);
		$this->addFlashMessage('Updated the ko round.');
		$this->redirect('index');
	}

	/**
	 * Removes the given ko round object from the ko round repository
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\KoRound $koRound The ko round to delete
	 * @return void
	 */
	public function deleteAction(KoRound $koRound) {
		$this->koRoundRepository->remove($koRound);
		$this->addFlashMessage('Deleted a ko round.');
		$this->redirect('index');
	}

}

?>