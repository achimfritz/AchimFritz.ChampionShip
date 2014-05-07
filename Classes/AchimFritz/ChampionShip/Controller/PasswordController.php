<?php
namespace AchimFritz\ChampionShip\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

use AchimFritz\ChampionShip\Domain\Model\Password;

/**
 * Team controller for the AchimFritz.ChampionShip package 
 *
 * @Flow\Scope("singleton")
 */
class PasswordController extends AbstractActionController {

	/**
	 * @var \TYPO3\Flow\Security\Cryptography\HashService
	 * @Flow\Inject
	 */
	protected $hashService;

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\UserRepository
	 */
	protected $userRepository;
	
	/**
	 * @var string
	 */
	protected $resourceArgumentName = 'password';

	/**
	 * Updates the given team object
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\Password $password
	 * @return void
	 */
	public function createAction(Password $password) {
		try {
			$user = $password->getUser();
			$user->getAccount()->setCredentialsSource($this->hashService->hashPassword($password->getNewPassword(), 'default'));
			$this->userRepository->update($user);
			$this->persistenceManager->persistAll();
			$this->addOkMessage('password updatet');
		} catch (\Exception $e) {
			$this->addErrorMessage('cannot update password');
			$this->handleException($e);
		}
		$this->redirect('index', 'User', NULL, array('user' => $password->getUser()));
	}



}

?>
