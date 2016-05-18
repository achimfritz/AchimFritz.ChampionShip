<?php
namespace AchimFritz\ChampionShip\Tip\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use AchimFritz\ChampionShip\User\Domain\Model\User;
use TYPO3\Flow\Annotations as Flow;


/**
 * Standard controller for the AchimFritz.ChampionShip package 
 *
 * @Flow\Scope("singleton")
 */
class UserTipController extends AbstractActionController {

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\User\Domain\Repository\UserRepository
	 */
	protected $userRepository;

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Tip\Domain\Repository\TipRepository
	 */
	protected $tipRepository;

	/**
	 * @var string
	 */
	protected $resourceArgumentName = 'user';

	/**
	 * Shows a list of users
	 *
	 * @return void
	 */
	public function listAction() {
		$this->view->assign('users', $this->userRepository->findAll());
	}

	/**
	 * @param User $user
	 * @return void
	 */
	public function showAction(User $user) {
		$tips = $this->tipRepository->findByUserInCup($user, $this->cup);
		$this->view->assign('tips', $tips);
		$this->view->assign('user', $user);
	}


}
