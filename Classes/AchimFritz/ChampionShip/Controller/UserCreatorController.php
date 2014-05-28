<?php
namespace AchimFritz\ChampionShip\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Domain\Model\RegistrationRequest;

/**
 * Team controller for the AchimFritz.ChampionShip package 
 *
 * @Flow\Scope("singleton")
 */
class UserCreatorController extends AbstractActionController {

	/**
	 * @var string
	 */
	protected $resourceArgumentName = 'registrationRequest';

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\RegistrationRequestRepository
	 */
	protected $registrationRequestRepository;

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
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Service\NotificationService
	 */
	protected $notificationService;

	/**
	 * @param \AchimFritz\ChampionShip\Domain\Model\RegistrationRequest $registrationRequest
	 * @return void
	 */
	public function createAction(RegistrationRequest $registrationRequest) {
		try {
			$user = $this->userFactory->createFromRegistrationRequest($registrationRequest);
			$this->registrationRequestRepository->remove($registrationRequest);
			$this->userRepository->add($user);
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

?>
