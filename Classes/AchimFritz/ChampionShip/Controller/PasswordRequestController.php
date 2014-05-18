<?php
namespace AchimFritz\ChampionShip\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

use AchimFritz\ChampionShip\Domain\Model\PasswordRequest;

/**
 * Team controller for the AchimFritz.ChampionShip package 
 *
 * @Flow\Scope("singleton")
 */
class PasswordRequestController extends AccountRequestController {

	/**
	 * @var string
	 */
	protected $resourceArgumentName = 'passwordRequest';

	/**
	 * listAction 
	 * 
	 * @return void
	 */
	public function listAction() {
	}

	/**
	 * createAction
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\PasswordRequest $passwordRequest
	 * @return void
	 */
	public function createAction(PasswordRequest $passwordRequest) {
		#$this->passwordRequestService->handle($passwordRequest);
		$this->addOkMessage('PasswordRequest created');
		$this->view->assign('passwordRequest', $passwordRequest);
	}



}

?>
