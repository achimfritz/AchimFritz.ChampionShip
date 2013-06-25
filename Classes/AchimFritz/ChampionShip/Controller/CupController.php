<?php
namespace AchimFritz\ChampionShip\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

use \AchimFritz\ChampionShip\Domain\Model\Cup;

/**
 * Cup controller for the AchimFritz.ChampionShip package 
 *
 * @Flow\Scope("singleton")
 */
class CupController extends ActionController {

	
	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\GroupRoundRepository
	 */
	protected $groupRoundRepository;
	
	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\KoRoundRepository
	 */
	protected $koRoundRepository;
		
	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\TeamRepository
	 */
	protected $teamRepository;

	/**
	 * Shows a list of cups
	 *
	 * @return void
	 */
	public function indexAction() {
#		$this->view->assign('cups', $this->cupRepository->findAll());
	}

	/**
	 * Shows a single cup object
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\Cup $cup The cup to show
	 * @return void
	 */
	public function showAction(Cup $cup) {
		$this->view->assign('cup', $cup);
		$this->view->assign('groupRounds', $this->groupRoundRepository->findByCup($cup));
		$this->view->assign('koRounds', $this->koRoundRepository->findByCup($cup));
	}

	/**
	 * Shows a form for creating a new cup object
	 *
	 * @return void
	 */
	public function newAction() {
		$this->view->assign('allTeams', $this->teamRepository->findAll());
	}

	/**
	 * Adds the given new cup object to the cup repository
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\Cup $newCup A new cup to add
	 * @return void
	 */
	public function createAction(Cup $newCup) {		
		try {
			$this->cupRepository->add($newCup);
			$this->persistenceManager->persistAll();
			$this->addOkMessage('cup created');
		} catch (\Exception $e) {
			$this->addErrorMessage('cannot create cup');
			$this->handleException($e);
		}		
		$this->redirect('index');
	}

	/**
	 * Shows a form for editing an existing cup object
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\Cup $cup The cup to edit
	 * @return void
	 */
	public function editAction(Cup $cup) {
		$this->view->assign('allTeams', $this->teamRepository->findAll());
		$this->view->assign('cup', $cup);
	}

	/**
	 * Updates the given cup object
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\Cup $cup The cup to update
	 * @return void
	 */
	public function updateAction(Cup $cup) {
		try {
			$this->cupRepository->update($cup);
			$this->persistenceManager->persistAll();
			$this->addOkMessage('cup updatet');
		} catch (\Exception $e) {
			$this->addErrorMessage('cannot update cup');
			$this->handleException($e);
		}
		$this->redirect('index');
	}

	/**
	 * Removes the given cup object from the cup repository
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\Cup $cup The cup to delete
	 * @return void
	 */
	public function deleteAction(Cup $cup) {
		try {
			$this->cupRepository->remove($cup);
			$this->persistenceManager->persistAll();
			$this->addOkMessage('cup deletet');
		} catch (\Exception $e) {
			$this->addErrorMessage('cannot delete cup');
			$this->handleException($e);
		}
		$this->redirect('index');
	}

}

?>
