<?php
namespace AchimFritz\ChampionShip\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Mvc\Controller\RestController;


/**
 * Action controller for the AchimFritz.ChampionShip package 
 *
 * @Flow\Scope("singleton")
 */
#class ActionController extends \TYPO3\Flow\Mvc\Controller\ActionController {
class ActionController extends RestController {

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
    * Supported content types. Needed for HTTP content negotiation.
    * @var array
    */
   protected $supportedMediaTypes = array('text/html', 'application/json', 'application/xml');

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
			if (isset($arg['__identity'])) {
				$cup = $this->cupRepository->findByIdentifier($arg['__identity']);
				$this->view->assign('recentCup', $cup);
			}
		} else {
			#$cup = $this->cupRepository->findOneRecent();
		}
		$cups = $this->cupRepository->findAll();
		$this->view->assign('cups', $cups);
		
		/*
		 * <f:security.ifHasRole role="Administrator">
        This is being shown in case you have the Administrator role (aka role).
</f:security.ifHasRole>
		 */
		
		$tokens = $this->securityContext->getAuthenticationTokens();
		foreach ($tokens as $token) {
			if ($token->isAuthenticated()) {
				$account = $token->getAccount();
				$this->view->assign('account', $account);
			}
		}
	}
	
	/**
	 * resolveViewObjectName
	 * 
	 * @return void
	 */
	protected function resolveViewObjectName() {
		$contentType = $this->request->getHttpRequest()->getNegotiatedMediaType($this->supportedMediaTypes);
		$format = $this->request->getFormat();
		if ($contentType === 'application/xml' OR $format === 'xml') {
			$this->request->setFormat('xml');
			$this->response->setHeader('Content-Type', 'application/xml');
			return parent::resolveViewObjectName();
		} elseif ($contentType === 'application/json' OR $format === 'json') {
			$this->request->setFormat('json');
			$this->response->setHeader('Content-Type', 'application/json');
			return parent::resolveViewObjectName();
			#return 'TYPO3\\Flow\\Mvc\\View\\JsonView';
		} else {
			return parent::resolveViewObjectName();
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
	 * addWarningMessage
	 * 
	 * @param string $message
	 */
	protected function addWarningMessage($message) {
		$this->addFlashMessage($message, '', \TYPO3\Flow\Error\Message::SEVERITY_WARNING);
	}
	/**
	 * addNoticeMessage
	 * 
	 * @param string $message
	 */
	protected function addNoticeMessage($message) {
		$this->addFlashMessage($message, '', \TYPO3\Flow\Error\Message::SEVERITY_NOTICE);
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

	/**
	 * errorAction 
	 * 
	 * @return void
	 */
	protected function errorAction() {
		$this->response->setStatus(400);
		return parent::errorAction();
	}

}

?>
