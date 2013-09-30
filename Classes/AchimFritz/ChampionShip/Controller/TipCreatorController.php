<?php
namespace AchimFritz\ChampionShip\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use \AchimFritz\ChampionShip\Domain\Model\User;

/**
 * Match controller for the AchimFritz.ChampionShip package 
 *
 * @Flow\Scope("singleton")
 */
class TipCreatorController extends ActionController {

	/**
	 * @var \AchimFritz\ChampionShip\Domain\Factory\TipFactory
	 * @Flow\Inject
	 */
	protected $tipFactory;
		
	/**
	 * @var string
	 */
	protected $resourceArgumentName = 'user';

	/**
	 * Updates the given user object
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\User $user The user to update
	 * @return void
	 */
	public function updateAction(User $user) {
		try {
			$this->tipFactory->initTips($user);
			$this->persistenceManager->persistAll();
			$this->addOkMessage('tips updated');
		} catch (\Exception $e) {
			$this->addErrorMessage('cannot update tips');
			$this->handleException($e);
		}		
		$this->redirect('show', 'User', NULL, array('user' => $user));
	}



}

?>
