<?php
namespace AchimFritz\ChampionShip\User\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Flow.Login".  *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU General Public License, either version 3 of the   *
 * License, or (at your option) any later version.                        *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

/**
 * A controller which allows for loggin into a application
 *
 * @Flow\Scope("singleton")
 */
class LoginController extends \TYPO3\Flow\Security\Authentication\Controller\AbstractAuthenticationController {

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\User\Domain\Repository\UserRepository
	 */
	protected $userRepository;


	/**
	 * @var \TYPO3\Flow\I18n\Translator
	 * @Flow\Inject
	 */
	protected $translator;

	/**
	 * @return string
	 */
	public function indexAction() {
		$account = $this->securityContext->getAccount();
		if ($account) {
			$user = $this->userRepository->findOneByAccount($account);
			$this->view->assign('user', $user);
		}
	}


	/**
	 * Is called if authentication was successful.
	 *
	 * @param \TYPO3\Flow\Mvc\ActionRequest $originalRequest The request that was intercepted by the security framework, NULL if there was none
	 * @return string
	 */
	public function onAuthenticationSuccess(\TYPO3\Flow\Mvc\ActionRequest $originalRequest = NULL) {
		$message = $this->translator->translateById('loginSuccess', array(), NULL, NULL, 'Main', 'AchimFritz.ChampionShip');
		$this->addFlashMessage($message, '', \TYPO3\Flow\Error\Message::SEVERITY_OK);
		$this->redirect('index', 'Standard', 'AchimFritz.ChampionShip\\Generic');
	}
	
	/**
	 * Logs all active tokens out. Override this, if you want to
	 * have some custom action here. You can always call the parent
	 * method to do the actual logout.
	 *
	 * @return void
	 */
	public function logoutAction() {
		parent::logoutAction();
		$message = $this->translator->translateById('logoutSuccess', array(), NULL, NULL, 'Main', 'AchimFritz.ChampionShip');
		$this->addFlashMessage($message, '', \TYPO3\Flow\Error\Message::SEVERITY_OK);
		$this->redirect('index', 'Standard', 'AchimFritz.ChampionShip\\Generic');
	}
	
	/**
	 * Is called if authentication failed.
	 *
	 * Override this method in your login controller to take any
	 * custom action for this event. Most likely you would want
	 * to redirect to some action showing the login form again.
	 *
	 * @param \TYPO3\Flow\Security\Exception\AuthenticationRequiredException $exception The exception thrown while the authentication process
	 * @return void
	 */
	protected function onAuthenticationFailure(\TYPO3\Flow\Security\Exception\AuthenticationRequiredException $exception = NULL) {
		$message = $this->translator->translateById('loginFailed', array(), NULL, NULL, 'Main', 'AchimFritz.ChampionShip');
		$this->addFlashMessage($message, '', \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
	}

	/**
	 * Collects the errors and serves them
	 *
	 * @return void
	 */
	protected function errorAction() {
		$this->redirect('index', 'Standard', 'AchimFritz.ChampionShip\\Generic');
	}

}
