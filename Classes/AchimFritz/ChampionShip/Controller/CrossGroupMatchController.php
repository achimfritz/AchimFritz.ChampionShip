<?php
namespace AchimFritz\ChampionShip\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

use \AchimFritz\ChampionShip\Domain\Model\Cup;
use \AchimFritz\ChampionShip\Domain\Model\CrossGroupMatch;

/**
 * Match controller for the AchimFritz.ChampionShip package 
 *
 * @Flow\Scope("singleton")
 */
class CrossGroupMatchController extends MatchController {
		
	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\KoMatchRepository
	 */
	protected $matchRepository;
	
	/**
	 * Adds the given new match object to the cup repository
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\CrossGroupMatch $match
	 * @return void
	 */
	public function createAction(CrossGroupMatch $match) {
		try {
			$this->matchRepository->add($match);
			$this->persistenceManager->persistAll();
			$this->addOkMessage('match created');
		} catch (\Exception $e) {
			$this->addErrorMessage('cannot create match');
			$this->handleException($e);
		}		
		#$this->redirect('index', 'KoMatch', NULL, array('match' => $match, 'cup' => $match->getCup()));
		$this->redirect('index', 'KoRound', NULL, array('round' => $match->getRound(), 'cup' => $match->getCup()));
	}

}

?>
