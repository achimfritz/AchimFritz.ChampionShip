<?php
namespace AchimFritz\ChampionShip\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

use \AchimFritz\ChampionShip\Domain\Model\Match;
use \AchimFritz\ChampionShip\Domain\Model\KoRound;
use \AchimFritz\ChampionShip\Domain\Model\Cup;

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
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\TeamRepository
	 */
	protected $teamRepository;


	/**
	 * @var string
	 */
	protected $resourceArgumentName = 'match';
	
	
	/**
	 * listAction
	 * 
	 * @param \AchimFritz\ChampionShip\Domain\Model\Cup $cup
	 */
	public function listAction(Cup $cup) {
		$matches = $this->matchRepository->findByCup($cup);
		$this->view->assign('matches', $matches);
		$this->view->assign('allTeams', $this->teamRepository->findAll());
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
			// TODO
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
			// TODO
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
