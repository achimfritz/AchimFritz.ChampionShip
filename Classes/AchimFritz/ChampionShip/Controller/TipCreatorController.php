<?php
namespace AchimFritz\ChampionShip\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

/**
 * Match controller for the AchimFritz.ChampionShip package 
 *
 * @Flow\Scope("singleton")
 */
class TipCreatorController extends ActionController {
		
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
			#$this->userRepository->update($user);
			#$this->persistenceManager->persistAll();
			$this->addOkMessage('user updated');
		} catch (\Exception $e) {
			$this->addErrorMessage('cannot update user');
			$this->handleException($e);
		}		
		$this->redirect('index', 'User');
	}



}

?>
