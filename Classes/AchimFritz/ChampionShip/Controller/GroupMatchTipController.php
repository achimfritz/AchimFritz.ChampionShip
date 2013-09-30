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
class GroupMatchTipController extends ActionController {
		
	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\TipRepository
	 */
	protected $tipRepository;

	/**
	 * @var string
	 */
	protected $resourceArgumentName = 'tip';

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\UserRepository
	 */
	protected $userRepository;

	/**
	 * @var \TYPO3\Flow\Security\Context
	 * @Flow\Inject
	 */
	protected $securityContext;
	
	/**
	 * listAction
	 * 
	 * @param \AchimFritz\ChampionShip\Domain\Model\Cup $cup
	 */
	public function listAction(Cup $cup) {
		$account = $this->securityContext->getAccount();
		$user = $this->userRepository->findOneByAccount($account);
		$tips = $this->tipRepository->findByUser($user);
		return count($tips) . 'x';
		$account = $this->securityContext->getAccount();
		return $account->getAccountIdentifier();
		#$matches = $this->matchRepository->findByCup($cup);
		#$this->view->assign('matches', $matches);
		#$this->view->assign('allTeams', $this->teamRepository->findAll());
		#$this->view->assign('allGroupRounds', $this->groupRoundRepository->findByCup($cup));
		#$this->view->assign('allKoRounds', $this->koRoundRepository->findByCup($cup));
	}


}

?>
