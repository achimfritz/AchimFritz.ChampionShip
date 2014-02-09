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
	 * @var \AchimFritz\ChampionShip\Domain\Repository\TipRepository
	 * @Flow\Inject
	 */
	protected $tipRepository;

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\UserRepository
	 */
	protected $userRepository;

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Factory\UserFactory
	 */
	protected $userFactory;


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
		$this->view->assign('allTipGroups', $this->tipGroupRepository->findAll());
		$this->view->assign('users', $this->userRepository->findAll());
	}

	/**
	 * Shows a single user object
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\User $user The user to show
	 * @return void
	 */
	public function showAction(User $user) {
		$this->view->assign('allTipGroups', $this->tipGroupRepository->findAll());
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
			$user = $this->userFactory->create($user->getEmail(), $user->getAccount()->getAccountIdentifier());
			$this->userRepository->add($user);
			$this->persistenceManager->persistAll();
			$this->addOkMessage('user created');
		} catch (\Exception $e) {
			$this->addErrorMessage('cannot create user');
			$this->handleException($e);
		}		
		$this->redirect('index', NULL, NULL, array('user' => $user));
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
		$this->redirect('index', NULL, NULL, array('user' => $user));
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
