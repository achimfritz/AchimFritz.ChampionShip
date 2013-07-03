<?php
namespace AchimFritz\ChampionShip\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

use \AchimFritz\ChampionShip\Domain\Model\Cup;
use \AchimFritz\ChampionShip\Domain\Model\GroupRound;

/**
 * Match controller for the AchimFritz.ChampionShip package 
 *
 * @Flow\Scope("singleton")
 */
class KoMatchController extends ActionController {
		
	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\KoMatchRepository
	 */
	protected $koMatchRepository;
	
	/**
	 * updateFromGroupRoundAction
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\GroupRound
	 * @return void
	 */
	public function updateFromGroupRoundAction(GroupRound $groupRound) {
		try {
			$match = $this->koMatchRepository->findOneInGroupRoundWithRank($groupRound, 1);
			#return get_class($match);
			return $match->getName();
			/*
			 * $this->matchService->....
			 * 
			$match = $this->groupMatchRepository->findOneInGroupRoundWithRank($groupRound, 1);
			$team = $groupRound->getWinnerTeam();
			$match->setTeam($team);
			$this->matchRepository->update($match);
			$match = $this->groupMatchRepository->findOneInGroupRoundWithRank($groupRound, 2);
			$team = $groupRound->getSecondTeam();
			$match->setTeam($team);
			$this->matchRepository->update($match);
			*/
			#$this->persistenceManager->persistAll();
			$this->addOkMessage('matches updatet');
		} catch (\Exception $e) {
			$this->addErrorMessage('cannot update match');
			$this->handleException($e);
		}
		$this->redirect('list', 'GroupRound', NULL, array('cup' => $groupRound->getCup(), 'groupRound' => $groupRound));
	}
	

}

?>