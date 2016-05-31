<?php
namespace AchimFritz\ChampionShip\Tip\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use AchimFritz\ChampionShip\User\Domain\Model\User;
use AchimFritz\ChampionShip\User\Domain\Model\TipGroup;
use TYPO3\Flow\Annotations as Flow;


/**
 * Standard controller for the AchimFritz.ChampionShip package 
 *
 * @Flow\Scope("singleton")
 */
class UserTipController extends AbstractTipGroupController {

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
	 * @return void
	 * @param \AchimFritz\ChampionShip\User\Domain\Model\TipGroup $tipGroup
	 */
	public function listAction(TipGroup $tipGroup = NULL) {
		if ($tipGroup === NULL) {
			if ($this->user instanceof User) {
				$tipGroup = $this->user->getTipGroup();
			} else {
				// admin only
				$tipGroup = $this->tipGroupRepository->findAll()->getFirst();
			}
		}
		$users = $this->userRepository->findInTipGroup($tipGroup);
		#$users = $this->userRepository->findAll();
		$this->view->assign('users', $users);
		$this->view->assign('tipGroup', $tipGroup);
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
