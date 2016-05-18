<?php
namespace AchimFritz\ChampionShip\Tip\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Error\Message;
use TYPO3\Flow\Security\Account;
use TYPO3\Flow\Mvc\Controller\RestController;
use \AchimFritz\ChampionShip\Competition\Domain\Model\Cup;
use \AchimFritz\ChampionShip\User\Domain\Model\User;


/**
 * Action controller for the AchimFritz.ChampionShip package 
 *
 * @Flow\Scope("singleton")
 */
class AbstractActionController extends \AchimFritz\ChampionShip\Competition\Controller\AbstractActionController {

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\User\Domain\Repository\UserRepository
	 */
	protected $userRepository;

	/**
	 * @var \TYPO3\Flow\Security\Context
	 * @Flow\Inject
	 */
	protected $securityContext;

	/**
	 * @var User
	 */
	protected $user = NULL;

	/**
	 * @var Account
	 */
	protected $account = NULL;


	/**
	 * initializeAction 
	 * 
	 * @return void
	 */
	protected function initializeAction() {
		parent::initializeAction();
		$this->account = $this->securityContext->getAccount();
		if ($this->account) {
			$user = $this->userRepository->findOneByAccount($this->account);
			if ($user instanceof User) {
				$this->user = $user;
			}
		}
	}

	/**
	 * handleException
	 * 
	 * @param \Exception $e
	 * @return void
	 */
	protected function handleException(\Exception $e) {
		if ($this->user === NULL && $this->account !== NULL) {
			// must be an admin
			$this->addFlashMessage($e->getMessage(), get_class($e), Message::SEVERITY_ERROR, array(), $e->getCode());
		}
	}

}