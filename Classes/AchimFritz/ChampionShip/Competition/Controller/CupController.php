<?php
namespace AchimFritz\ChampionShip\Competition\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use \AchimFritz\ChampionShip\Competition\Domain\Model\Cup;

/**
 * Cup controller for the AchimFritz.ChampionShip package 
 *
 * @Flow\Scope("singleton")
 */
class CupController extends \AchimFritz\ChampionShip\Generic\Controller\AbstractActionController {

	
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
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\TeamRepository
	 */
	protected $teamRepository;

	/**
	 * @var string
	 */
	protected $resourceArgumentName = 'cup';
	
	/**
	 * listAction
	 * 
	 * @return void
	 */
	public function listAction() {
		$cups = $this->cupRepository->findAll();
		$this->view->assign('cups', $cups);
		$this->view->assign('allTeams', $this->teamRepository->findAll());
	}

	/**
	 * Shows a single cup object
	 *
	 * @param \AchimFritz\ChampionShip\Competition\Domain\Model\Cup $cup The cup to show
	 * @return void
	 */
	public function showAction(Cup $cup) {
		$this->view->assign('allTeams', $this->teamRepository->findAll());
		$this->view->assign('cup', $cup);
		$this->view->assign('groupRounds', $this->groupRoundRepository->findByCup($cup));
		$this->view->assign('koRounds', $this->koRoundRepository->findByCup($cup));
	}

	/**
	 * Adds the given new cup object to the cup repository
	 *
	 * @param \AchimFritz\ChampionShip\Competition\Domain\Model\Cup $cup A new cup to add
	 * @return void
	 */
	public function createAction(Cup $cup) {
		try {
			$this->cupRepository->add($cup);
			$this->persistenceManager->persistAll();
			$this->addOkMessage('cup created');
		} catch (\Exception $e) {
			$this->addErrorMessage('cannot create cup');
			$this->handleException($e);
		}		
		$this->redirect('index', 'Cup', NULL, array('cup' => $cup));
	}

	/**
	 * Updates the given cup object
	 *
	 * @param \AchimFritz\ChampionShip\Competition\Domain\Model\Cup $cup The cup to update
	 * @return void
	 */
	public function updateAction(Cup $cup) {
		try {
			$this->cupRepository->update($cup);
			$this->persistenceManager->persistAll();
			$this->addOkMessage('cup updated');
		} catch (\Exception $e) {
			$this->addErrorMessage('cannot update cup');
			$this->handleException($e);
		}
		$this->redirect('index', 'Cup', NULL, array('cup' => $cup));
	}

	/**
	 * Removes the given cup object from the cup repository
	 *
	 * @param \AchimFritz\ChampionShip\Competition\Domain\Model\Cup $cup The cup to delete
	 * @return void
	 */
	public function deleteAction(Cup $cup) {
		try {
			$this->cupRepository->remove($cup);
			$this->persistenceManager->persistAll();
			$this->addOkMessage('cup deleted');
		} catch (\Exception $e) {
			$this->addErrorMessage('cannot delete cup');
			$this->handleException($e);
		}
		\TYPO3\Flow\Mvc\Controller\RestController::redirect('index');
	}

}

?>
