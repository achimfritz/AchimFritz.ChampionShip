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
class TeamController extends AbstractActionController {

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
	 * @var string
	 */
	protected $resourceArgumentName = 'team';

	/**
	 * Shows a list of teams
	 *
	 * @return void
	 */
	public function listAction() {
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
	 * Adds the given new team object to the team repository
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\Team $team A new team to add
	 * @return void
	 */
	public function createAction(Team $team) {
		try {
			$this->teamRepository->add($team);
			$this->persistenceManager->persistAll();
			$this->addOkMessage('team createt');
		} catch (\Exception $e) {
			$this->addErrorMessage('cannot create team');
			$this->handleException($e);
		}
		$this->redirect('index', 'Team', NULL, array('team' => $team));
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
		$this->redirect('index', 'Team', NULL, array('team' => $team));
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
