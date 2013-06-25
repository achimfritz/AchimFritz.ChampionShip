<?php
namespace AchimFritz\ChampionShip\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

/**
 * Action controller for the AchimFritz.ChampionShip package 
 *
 * @Flow\Scope("singleton")
 */
class ActionController extends \TYPO3\Flow\Mvc\Controller\ActionController {

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\CupRepository
	 */
	protected $cupRepository;
	
	/**
	 * @var \TYPO3\Flow\Security\Context
	 * @Flow\Inject
	 */
	protected $securityContext;

	/**
	 * initializeView
	 * 
	 * @return void
	 */
	protected function initializeView(\TYPO3\Flow\Mvc\View\ViewInterface $view) {
		$view->assign('controllers', array('Team', 'User', 'Cup', 'Standard'));
		$view->assign('title', $this->request->getControllerName() . '->' . $this->request->getControllerActionName());
		
		
		if ($this->request->hasArgument('cup')) {
			$arg = $this->request->getArgument('cup');
			$cup = $this->cupRepository->findByIdentifier($arg['__identity']);
		} else {
			$cup = $this->cupRepository->findOneRecent();
		}
		$cups = $this->cupRepository->findAll();
		$this->view->assign('recentCup', $cup);
		$this->view->assign('cups', $cups);
		
		$tokens = $this->securityContext->getAuthenticationTokens();
		foreach ($tokens as $token) {
			if ($token->isAuthenticated()) {
				$account = $token->getAccount();
				$this->view->assign('account', $account);
			}
		}
	}

	/**
	 * addErrorMessage
	 * 
	 * @param string $message
	 */
	protected function addErrorMessage($message) {
		$this->addFlashMessage($message, '', \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
	}
	
	/**
	 * addOkMessage
	 * 
	 * @param string $message
	 */
	protected function addOkMessage($message) {
		$this->addFlashMessage($message, '', \TYPO3\Flow\Error\Message::SEVERITY_OK);
	}
	
	/**
	 * handleException
	 * 
	 * @param \Exception $e
	 */
	protected function handleException(\Exception $e) {
		$this->addFlashMessage($e->getMessage(), get_class($e), \TYPO3\Flow\Error\Message::SEVERITY_ERROR, array(), $e->getCode());
	}

}

?>
