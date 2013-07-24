<?php
namespace AchimFritz\ChampionShip\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

use \AchimFritz\ChampionShip\Domain\Model\GroupMatch;
use \AchimFritz\ChampionShip\Domain\Model\Cup;

/**
 * Match controller for the AchimFritz.ChampionShip package 
 *
 * @Flow\Scope("singleton")
 */
class GroupMatchController extends MatchController {
		
	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\GroupMatchRepository
	 */
	protected $matchRepository;

	/**
	 * @var string
	 */
	#protected $resourceArgumentName = 'groupMatch';

	/**
	 * Adds the given new match object to the cup repository
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\GroupMatch $match
	 * @return void
	 */
	public function createAction(GroupMatch $match) {
		try {
			$this->matchRepository->add($match);
			$this->persistenceManager->persistAll();
			$this->addOkMessage('match created');
		} catch (\Exception $e) {
			$this->addErrorMessage('cannot create match');
			$this->handleException($e);
		}		
		$this->redirect('index', 'GroupMatch', NULL, array('cup' => $match->getCup()));
	}
}

?>
