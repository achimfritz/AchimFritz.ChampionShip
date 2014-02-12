<?php
namespace AchimFritz\ChampionShip\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Security\Account;

/**
 * Team controller for the AchimFritz.ChampionShip package 
 *
 * @Flow\Scope("singleton")
 */
class TestLoginController extends \TYPO3\Flow\Mvc\Controller\ActionController {

	/**
	 * @var \TYPO3\Flow\Security\Context
	 * @Flow\Inject
	 */
	protected $securityContext;

	/**
	 * listAction 
	 * 
	 * @return void
	 */
	public function indexAction() {
		$account = $this->securityContext->getAccount();
		if ($account instanceof Account) {
			return 'ok ' . $account->getAccountIdentifier();
		} else {
			return 'not authenticated';
		}
	}

}

?>
