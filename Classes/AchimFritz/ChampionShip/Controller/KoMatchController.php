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
class KoMatchController extends MatchController {
		
	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\KoMatchRepository
	 */
	protected $matchRepository;
	
	/**
	 * @var string
	 */
	protected $resourceArgumentName = 'koMatch';

	/**
	 * updateFromGroupRoundAction
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\GroupRound
	 * @return void
	 */
	public function updateFromGroupRoundAction(GroupRound $groupRound) {
		return 'TODO';
		try {
			// TODO $groupRound->hasValidGroupTableRows()
			$winner = $groupRound->getWinnerTeam();
			$second = $groupRound->getSecondTeam();
			$match = $this->koMatchRepository->findOneInGroupRoundWithRank($groupRound, 1);
			#return $match->getName();
			$hostParticipant = $match->getHostParticipant();
			if ($hostParticipant->getRankOfGroupRound() === 1 AND $hostParticipant->getGroupRound() === $groupRound) {
				$hostParticipant->setTeam($winner);
			}
			$guestParticipant = $match->getGuestParticipant();
			if ($guestParticipant->getRankOfGroupRound() === 1 AND $guestParticipant->getGroupRound() === $groupRound) {
				$guestParticipant->setTeam($winner);
			}
			$this->koMatchRepository->update($match);
			$content = $match->getName();
			$this->persistenceManager->persistAll();
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
