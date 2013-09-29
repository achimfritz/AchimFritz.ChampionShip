<?php
namespace AchimFritz\ChampionShip\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

use \AchimFritz\ChampionShip\Domain\Model\User;

/**
 * User controller for the AchimFritz.ChampionShip package 
 *
 * @Flow\Scope("singleton")
 */
class UserController extends ActionController {

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\TipGroupRepository
	 */
	protected $tipGroupRepository;

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\UserRepository
	 */
	protected $userRepository;

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
	 * Shows a single user object
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\User $user The user to show
	 * @return void
	 */
	public function showAction(User $user) {
		$tipGroups = $this->tipGroupRepository->findByUser($user);
		$this->view->assign('tipGroups', $tipGroups);
		$this->view->assign('user', $user);
	}

	/**
	 * Adds the given new user object to the user repository
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\User $user A new user to add
	 * @return void
	 */
	public function createAction(User $user) {
		try {
			$this->userRepository->add($user);
			$this->persistenceManager->persistAll();
			$this->addOkMessage('user created');
		} catch (\Exception $e) {
			$this->addErrorMessage('cannot create user');
			$this->handleException($e);
		}		
		$this->redirect('index');
	}

	/**
	 * Updates the given user object
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\User $user The user to update
	 * @return void
	 */
	public function updateAction(User $user) {
		try {
			$this->userRepository->update($user);
			$this->persistenceManager->persistAll();
			$this->addOkMessage('user updated');
		} catch (\Exception $e) {
			$this->addErrorMessage('cannot update user');
			$this->handleException($e);
		}		
		$this->redirect('index');
	}

	/**
	 * Removes the given user object from the user repository
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\User $user The user to delete
	 * @return void
	 */
	public function deleteAction(User $user) {
		try {
			$this->userRepository->remove($user);
			$this->persistenceManager->persistAll();
			$this->addOkMessage('user deleted');
		} catch (\Exception $e) {
			$this->addErrorMessage('cannot delete user');
			$this->handleException($e);
		}		
		$this->redirect('index');
	}

}

?>
