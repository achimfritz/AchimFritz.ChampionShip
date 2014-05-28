<?php
namespace AchimFritz\ChampionShip\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use \AchimFritz\ChampionShip\Domain\Model\Tip;
use \AchimFritz\ChampionShip\Domain\Model\Match;
use \AchimFritz\ChampionShip\Domain\Model\User;
use \AchimFritz\ChampionShip\Domain\Model\Cup;

/**
 * Standard controller for the AchimFritz.ChampionShip package 
 *
 * @Flow\Scope("singleton")
 */
class UserTipController extends TipController {

	/**
	 * @var \AchimFritz\ChampionShip\Domain\Model\User
	 */
	protected $user;

	/**
	 * @var \TYPO3\Flow\Security\Context
	 * @Flow\Inject
	 */
	protected $securityContext;

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\MatchRepository
	 */
	protected $matchRepository;

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Factory\TipFactory
	 */
	protected $tipFactory;

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\UserRepository
	 */
	protected $userRepository;
	
	/**
	 * initializeView
	 * 
	 * @return void
	 */
	protected function initializeAction() {
		parent::initializeAction();
		$account = $this->securityContext->getAccount();
		$this->user = $this->userRepository->findOneByAccount($account);
	}

}

?>
