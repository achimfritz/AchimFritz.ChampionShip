<?php
namespace AchimFritz\ChampionShip\User\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use AchimFritz\ChampionShip\Generic\Controller\AbstractActionController;
use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\User\Domain\Model\User;

/**
 * User controller for the AchimFritz.ChampionShip package
 *
 * @Flow\Scope("singleton")
 */
class UserController extends AbstractActionController
{

    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\User\Domain\Repository\TipGroupRepository
     */
    protected $tipGroupRepository;

    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\User\Domain\Factory\UserFactory
     */
    protected $userFactory;

    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\User\Domain\Repository\UserRepository
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
    public function listAction()
    {
        $this->view->assign('allTipGroups', $this->tipGroupRepository->findAll());
        $this->view->assign('users', $this->userRepository->findAll());
    }

    /**
     * Shows a single user object
     *
     * @param \AchimFritz\ChampionShip\User\Domain\Model\User $user The user to show
     * @return void
     */
    public function showAction(User $user)
    {
        $this->view->assign('allTipGroups', $this->tipGroupRepository->findAll());
        $this->view->assign('user', $user);
    }

    /**
     * Adds the given new user object to the user repository
     *
     * @param \AchimFritz\ChampionShip\User\Domain\Model\User $user A new user to add
     * @return void
     */
    public function createAction(User $user)
    {
        try {
            $newUser = $this->userFactory->create($user->getEmail(), $user->getAccount()->getAccountIdentifier());
            $newUser->setTipGroup($user->getTipGroup());
            $newUser->setTipGroups($user->getTipGroups());
            $this->userRepository->add($newUser);
            $this->persistenceManager->persistAll();
            $this->addOkMessage('user created');
        } catch (\Exception $e) {
            $this->addErrorMessage('cannot create user');
            $this->handleException($e);
            $this->redirect('index');
        }
        $this->redirect('index', null, null, array('user' => $newUser));
    }

    /**
     * Updates the given user object
     *
     * @param \AchimFritz\ChampionShip\User\Domain\Model\User $user The user to update
     * @return void
     */
    public function updateAction(User $user)
    {
        try {
            $this->userRepository->update($user);
            $this->persistenceManager->persistAll();
            $this->addOkMessage('user updated');
        } catch (\Exception $e) {
            $this->addErrorMessage('cannot update user');
            $this->handleException($e);
        }
        $this->redirect('index', null, null, array('user' => $user));
    }

    /**
     * Removes the given user object from the user repository
     *
     * @param \AchimFritz\ChampionShip\User\Domain\Model\User $user The user to delete
     * @return void
     */
    public function deleteAction(User $user)
    {
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
