<?php
namespace AchimFritz\ChampionShip\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

use \AchimFritz\ChampionShip\Domain\Model\Match;
use \AchimFritz\ChampionShip\Domain\Model\KoRound;
use \AchimFritz\ChampionShip\Domain\Model\GroupRound;
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
	 * @var \AchimFritz\ChampionShip\Domain\Repository\TipRepository
	 */
	protected $tipRepository;

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\KoRoundRepository
	 */
	protected $koRoundRepository;

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\GroupRoundRepository
	 */
	protected $groupRoundRepository;

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
		$this->view->assign('allGroupRounds', $this->groupRoundRepository->findByCup($cup));
		$this->view->assign('allKoRounds', $this->koRoundRepository->findByCup($cup));
		$this->view->assign('recentCup', $cup);
	}

	/**
	 * showAction
	 * 
	 * @param \AchimFritz\ChampionShip\Domain\Model\Match $match
	 */
	public function showAction(Match $match) {
		$this->view->assign('match', $match);
		$cup = $match->getCup();
		$tips = $this->tipRepository->findByGeneralMatch($match);
		$this->view->assign('tips', $tips);
		$this->view->assign('allTeams', $this->teamRepository->findAll());
		$this->view->assign('allGroupRounds', $this->groupRoundRepository->findByCup($cup));
		$this->view->assign('allKoRounds', $this->koRoundRepository->findByCup($cup));
		$this->view->assign('recentCup', $match->getCup());
	}

	/**
	 * updateMatch
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\Match $match The match to update
	 * @return void
	 */
	protected function updateMatch(Match $match) {
		try {
			$this->matchRepository->update($match);
			$this->persistenceManager->persistAll();
			$this->addOkMessage('match updated');
		} catch (\Exception $e) {
			$this->addErrorMessage('cannot update match');
			$this->handleException($e);
		}
	}

	/**
	 * deleteMatch
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\Match $match The match to update
	 * @return void
	 */
	protected function deleteMatch(Match $match) {
		try {
			$this->matchRepository->remove($match);
			$this->persistenceManager->persistAll();
			$this->addOkMessage('match deleted');
		} catch (\Exception $e) {
			$this->addErrorMessage('cannot delete match');
			$this->handleException($e);
		}
	}

	/**
	 * createMatch
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\Match $match
	 * @return void
	 */
	protected function createMatch(Match $match) {
		try {
			$this->matchRepository->add($match);
			$this->persistenceManager->persistAll();
			$this->addOkMessage('match created');
		} catch (\Exception $e) {
			$this->addErrorMessage('cannot create match');
			$this->handleException($e);
		}		
	}

}

?>
