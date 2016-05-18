<?php
namespace AchimFritz\ChampionShip\User\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use AchimFritz\Rest\Controller\RestController;
use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\User\Domain\Model\RegistrationRequest;

/**
 * Team controller for the AchimFritz.ChampionShip package 
 *
 * @Flow\Scope("singleton")
 */
class UserCreatorController extends RestController {

	/**
	 * @var string
	 */
	protected $resourceArgumentName = 'registrationRequest';

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\User\Domain\Repository\RegistrationRequestRepository
	 */
	protected $registrationRequestRepository;

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\User\Domain\Repository\UserRepository
	 */
	protected $userRepository;

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\User\Domain\Factory\UserFactory
	 */
	protected $userFactory;

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Service\NotificationService
	 */
	protected $notificationService;

	/**
	 * @param \AchimFritz\ChampionShip\User\Domain\Model\RegistrationRequest $registrationRequest
	 * @return void
	 */
	public function createAction(RegistrationRequest $registrationRequest) {
		try {
			$user = $this->userFactory->createFromRegistrationRequest($registrationRequest);
			$this->userRepository->add($user);
			$this->registrationRequestRepository->remove($registrationRequest);
			$this->persistenceManager->persistAll();
			$this->addOkMessage('user created');
		} catch (\Exception $e) {
			$this->addErrorMessage('cannot create user');
			$this->handleException($e);
			$this->redirect('index');
		}
		try {
			$this->notificationService->registrationFinished($user);
		} catch (\Exception $e) {
			$this->addErrorMessage('cannot create user');
			$this->handleException($e);
			$this->redirect('index');
		}		
		$this->redirect('index', 'User', NULL, array('user' => $user));
	}

}
