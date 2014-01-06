<?php
namespace AchimFritz\ChampionShip\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use \AchimFritz\ChampionShip\Domain\Model\User;
use \AchimFritz\ChampionShip\Domain\Model\Cup;

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
	protected $resourceArgumentName = 'cup';

	/**
	 * create non existing tips for user
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\Cup $cup
	 * @param \AchimFritz\ChampionShip\Domain\Model\User $user The user to update
	 * @return void
	 */
	public function createAction(Cup $cup, User $user = NULL) {
		try {
			$newTips = $this->tipFactory->initTips($cup, $user);
			$this->persistenceManager->persistAll();
			$this->addOkMessage(count($newTips) . ' tips created');
		} catch (\Exception $e) {
			$this->addErrorMessage('cannot create tips');
			$this->handleException($e);
		}		
		if ($user !== NULL) {
			$this->redirect('show', 'User', NULL, array('user' => $user, 'cup' => $cup));
		} else {
			$this->redirect('show', 'Cup', NULL, array('cup' => $cup));
		}
	}



}

?>
