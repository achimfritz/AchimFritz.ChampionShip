<?php
namespace AchimFritz\ChampionShip\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

use AchimFritz\ChampionShip\Domain\Model\Registration;

/**
 * Team controller for the AchimFritz.ChampionShip package 
 *
 * @Flow\Scope("singleton")
 */
class RegistrationController extends ActionController {

	/**
	 * @var string
	 */
	protected $resourceArgumentName = 'registration';

	/**
	 * @var \AchimFritz\ChampionShip\Domain\Factory\UserFactory
	 * @Flow\Inject
	 */
	protected $userFactory;

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\UserRepository
	 */
	protected $userRepository;

	/**
	 * listAction 
	 * 
	 * @return void
	 */
	public function listAction() {
	}

	/**
	 * Updates the given team object
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\Registration $registration
	 * @return void
	 */
	public function createAction(Registration $registration) {
		try {
			$user = $this->userFactory->createFromRegistration($registration);
			$this->userRepository->add($user);
			$this->persistenceManager->persistAll();
			$this->addOkMessage('user created');
			//$this->view->assI
		} catch (\Exception $e) {
			$this->addErrorMessage('cannot create user');
			$this->handleException($e);
			$this->redirect('index', NULL, NULL, array());
		}
	}



}

?>
