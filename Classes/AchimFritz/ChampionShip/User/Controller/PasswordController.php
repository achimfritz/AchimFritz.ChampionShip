<?php
namespace AchimFritz\ChampionShip\User\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use AchimFritz\ChampionShip\Generic\Controller\AbstractActionController;
use Neos\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\User\Domain\Model\Password;

/**
 * Team controller for the AchimFritz.ChampionShip package
 *
 * @Flow\Scope("singleton")
 */
class PasswordController extends AbstractActionController
{

    /**
     * @var \Neos\Flow\Security\Cryptography\HashService
     * @Flow\Inject
     */
    protected $hashService;

    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\User\Domain\Repository\UserRepository
     */
    protected $userRepository;
    
    /**
     * @var string
     */
    protected $resourceArgumentName = 'password';

    /**
     * Updates the given team object
     *
     * @param \AchimFritz\ChampionShip\User\Domain\Model\Password $password
     * @return void
     */
    public function createAction(Password $password)
    {
        try {
            $user = $password->getUser();
            $user->getAccount()->setCredentialsSource($this->hashService->hashPassword($password->getNewPassword(), 'default'));
            $this->userRepository->update($user);
            $this->persistenceManager->persistAll();
            $this->addOkMessage('password updated');
        } catch (\Exception $e) {
            $this->addErrorMessage('cannot update password');
            $this->handleException($e);
        }
        $this->redirect('index', 'User', null, array('user' => $password->getUser()));
    }
}
