<?php
namespace AchimFritz\ChampionShip\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

use AchimFritz\ChampionShip\Domain\Model\Team;

/**
 * Team controller for the AchimFritz.ChampionShip package 
 *
 * @Flow\Scope("singleton")
 */
class TeamController extends ActionController {

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\TeamRepository
	 */
	protected $teamRepository;
	
	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\MatchRepository
	 */
	protected $matchRepository;

	/**
	 * Shows a list of teams
	 *
	 * @return void
	 */
	public function indexAction() {
		$this->view->assign('teams', $this->teamRepository->findAll());
	}

	/**
	 * Shows a single team object
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\Team $team The team to show
	 * @return void
	 */
	public function showAction(Team $team) {
		$this->view->assign('matches', $this->matchRepository->findByTeam($team));
		$this->view->assign('team', $team);
	}

	/**
	 * Shows a form for creating a new team object
	 *
	 * @return void
	 */
	public function newAction() {
	}

	/**
	 * Adds the given new team object to the team repository
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\Team $newTeam A new team to add
	 * @return void
	 */
	public function createAction(Team $newTeam) {
		try {
			$this->teamRepository->add($newTeam);
			$this->persistenceManager->persistAll();
			$this->addOkMessage('team createt');
		} catch (\Exception $e) {
			$this->addErrorMessage('cannot create team');
			$this->handleException($e);
		}
		$this->redirect('index');
	}

	/**
	 * Shows a form for editing an existing team object
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\Team $team The team to edit
	 * @return void
	 */
	public function editAction(Team $team) {
		$this->view->assign('team', $team);
	}

	/**
	 * Updates the given team object
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\Team $team The team to update
	 * @return void
	 */
	public function updateAction(Team $team) {
		try {
			$this->teamRepository->update($team);
			$this->persistenceManager->persistAll();
			$this->addOkMessage('team updated');
		} catch (\Exception $e) {
			$this->addErrorMessage('cannot update team');
			$this->handleException($e);
		}
		$this->redirect('index');
	}

	/**
	 * Removes the given team object from the team repository
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\Team $team The team to delete
	 * @return void
	 */
	public function deleteAction(Team $team) {
		try {
			$this->teamRepository->remove($team);
			$this->persistenceManager->persistAll();
			$this->addOkMessage('team deleted');
		} catch (\Exception $e) {
			$this->addErrorMessage('cannot delete team');
			$this->handleException($e);
		}
		$this->redirect('index');
	}

}

?>