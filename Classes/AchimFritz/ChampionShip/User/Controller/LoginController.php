<?php
namespace AchimFritz\ChampionShip\Controller;

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
	 * Is called if authentication was successful.
	 *
	 * @param \TYPO3\Flow\Mvc\ActionRequest $originalRequest The request that was intercepted by the security framework, NULL if there was none
	 * @return string
	 */
	public function onAuthenticationSuccess(\TYPO3\Flow\Mvc\ActionRequest $originalRequest = NULL) {
		$message = 'logged in';
		$this->addFlashMessage($message, '', \TYPO3\Flow\Error\Message::SEVERITY_OK);
		if ($originalRequest !== NULL) {
			$this->redirectToRequest($originalRequest);
		} else {
			$this->redirect('index', 'Standard');
		}
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
		$message = 'logged out';
		$this->addFlashMessage($message, '', \TYPO3\Flow\Error\Message::SEVERITY_OK);
		$this->redirect('index', 'Standard');
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
		$message = 'authentication failed';
		$this->addFlashMessage($message, '', \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
	}

	/**
	 * Collects the errors and serves them
	 *
	 * @return void
	 */
	protected function errorAction() {
		$this->redirect('index', 'Standard');
	}

}

?>