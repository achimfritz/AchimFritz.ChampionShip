<?php
namespace AchimFritz\ChampionShip\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

use \AchimFritz\ChampionShip\Domain\Model\Match;

/**
 * Match controller for the AchimFritz.ChampionShip package 
 *
 * @Flow\Scope("singleton")
 */
class MatchController extends ActionController {
	
	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\CupRepository
	 */
	protected $cupRepository;
	
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
	 * Shows a list of matches
	 *
	 * @return void
	 */
	public function indexAction() {
		$this->view->assign('matches', $this->matchRepository->findAll());
	}
	
	/**
	 * Shows a form for creating a new cup match object
	 *
	 * @return void
	 */
	public function newAction() {
		$this->view->assign('allTeams', $this->teamRepository->findAll());
		$this->view->assign('allCups', $this->cupRepository->findAll());
	}

	/**
	 * Shows a single match object
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\Match $match The match to show
	 * @return void
	 */
	public function showAction(Match $match) {
		$this->view->assign('match', $match);
	}


	/**
	 * Shows a form for editing an existing match object
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\Match $match The match to edit
	 * @return void
	 */
	public function editAction(Match $match) {
		$this->view->assign('allTeams', $this->teamRepository->findAll());
		$this->view->assign('allCups', $this->cupRepository->findAll());
		$this->view->assign('match', $match);
	}
	
	/**
	 * Adds the given new match object to the match repository
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\Match $newMatch A new match to add
	 * @return void
	 */
	public function createAction(Match $newMatch) {
		$this->matchRepository->add($newMatch);
		$this->addFlashMessage('Created a new match.');
		$this->redirect('index', 'Match');
	}
	
	/**
	 * Updates the given match object
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\Match $match The match to update
	 * @return void
	 */
	public function updateAction(Match $match) {
		$this->matchRepository->update($match);
		$this->addFlashMessage('Updated the match.');
		$this->redirect('index', 'Match');
	}

	/**
	 * Removes the given match object from the match repository
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\Match $match The match to delete
	 * @return void
	 */
	public function deleteAction(Match $match) {
		$this->matchRepository->remove($match);
		$this->addFlashMessage('Deleted a match.');
		$this->redirect('index', 'Match');
	}

}

?>