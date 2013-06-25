<?php
namespace AchimFritz\ChampionShip\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

use \AchimFritz\ChampionShip\Domain\Model\Match;
use \AchimFritz\ChampionShip\Domain\Model\KoRound;

/**
 * Match controller for the AchimFritz.ChampionShip package 
 *
 * @Flow\Scope("singleton")
 */
class MatchController extends ActionController {
		
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
	 * Shows a form for editing an existing match object
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\Match $match The match to edit
	 * @return void
	 */
	public function editAction(Match $match) {
		$this->view->assign('match', $match);
	}
	
	/**
	 * changeHost
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\Match $match
	 * @return void
	 */
	public function changeHostAction(Match $match) {
		$match->changeHost();
		$this->forward('update', 'Match', NULL, array('match' => $match));
	}
	
	/**
	 * editResultAction
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\Match $match
	 * @return void
	 */
	public function editResultAction(Match $match) {
		$this->view->assign('match', $match);
	}
		
	/**
	 * Updates the given match object
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\Match $match The match to update
	 * @return void
	 */
	public function updateAction(Match $match) {
		try {
			$this->matchRepository->update($match);
			$this->persistenceManager->persistAll();
			$this->addOkMessage('match updated');
		} catch (\Exception $e) {
			$this->addErrorMessage('cannot update match');
			$this->handleException($e);
		}
		$this->view->assign('match', $match);
	}

}

?>