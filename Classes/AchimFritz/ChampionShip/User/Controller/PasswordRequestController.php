<?php
namespace AchimFritz\ChampionShip\User\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use AchimFritz\ChampionShip\Generic\Controller\AbstractActionController;
use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\User\Domain\Model\Password;

/**
 * Team controller for the AchimFritz.ChampionShip package 
 *
 * @Flow\Scope("singleton")
 */
class PasswordRequestController extends AbstractActionController {

	/**
	 * @var \TYPO3\Flow\Security\Cryptography\HashService
	 * @Flow\Inject
	 */
	protected $hashService;

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\User\Domain\Repository\UserRepository
	 */
	protected $userRepository;

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\User\Domain\Repository\ForgotPasswordRequestRepository
	 */
	protected $forgotPasswordRequestRepository;
	
	/**
	 * @var string
	 */
	protected $resourceArgumentName = 'password';

	/**
	 * @param string $hash
	 * @return void
	 */
	public function listAction($hash = '') {
		$forgotPasswordRequest = $this->forgotPasswordRequestRepository->findOneByHash($hash);
		$this->view->assign('forgotPasswordRequest', $forgotPasswordRequest);
	}

	/**
	 * Updates the given team object
	 *
	 * @param \AchimFritz\ChampionShip\User\Domain\Model\Password $password
	 * @return void
	 */
	public function createAction(Password $password) {
		try {
			$forgotPasswordRequest = $this->forgotPasswordRequestRepository->findOneByHash($password->getHash());
			$user = $forgotPasswordRequest->getUser();
			$user->getAccount()->setCredentialsSource($this->hashService->hashPassword($password->getNewPassword(), 'default'));
			$this->userRepository->updateSecurityChecked($user);
			$forgotPasswordRequest->setHash('');
			$this->forgotPasswordRequestRepository->update($forgotPasswordRequest);
			$this->persistenceManager->persistAll();
			$this->addOkMessage('password updated');
		} catch (\Exception $e) {
			throw $e;
			$this->addErrorMessage('cannot update password');
			$this->handleException($e);
		}
		$this->redirect('index', 'Cup', 'AchimFritz.Championship\\Competition');
	}



}

?>
