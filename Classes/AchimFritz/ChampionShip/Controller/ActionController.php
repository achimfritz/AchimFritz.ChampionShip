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
	 * initializeView
	 * 
	 * @return void
	 */
	protected function initializeView(\TYPO3\Flow\Mvc\View\ViewInterface $view) {
		$view->assign('controllers', array('Team', 'User', 'Cup', 'Standard'));
		$view->assign('title', $this->request->getControllerName() . '->' . $this->request->getControllerActionName());
	}
	
	/**
	 * addErrorMessage
	 * 
	 * @param string $message
	 */
	protected function addErrorMessage($message) {
		$this->addFlashMessage($message, 'Error', \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
	}
	
	/**
	 * addOkMessage
	 * 
	 * @param string $message
	 */
	protected function addOkMessage($message) {
		$this->addFlashMessage($message, 'Ok', \TYPO3\Flow\Error\Message::SEVERITY_OK);
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