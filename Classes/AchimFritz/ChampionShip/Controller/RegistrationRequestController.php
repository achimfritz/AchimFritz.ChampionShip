<?php
namespace AchimFritz\ChampionShip\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

use AchimFritz\ChampionShip\Domain\Model\RegistrationRequest;

/**
 * Team controller for the AchimFritz.ChampionShip package 
 *
 * @Flow\Scope("singleton")
 */
class RegistrationRequestController extends ActionController {

	/**
	 * @var string
	 */
	protected $resourceArgumentName = 'registrationRequest';

	/**
	 * @var \AchimFritz\ChampionShip\Domain\Service\RegistrationRequestService
	 * @Flow\Inject
	 */
	protected $registrationRequestService;

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
	 * @param \AchimFritz\ChampionShip\Domain\Model\RegistrationRequest $registrationRequest
	 * @return void
	 */
	public function createAction(RegistrationRequest $registrationRequest) {
		$this->registrationRequestService->handle($registrationRequest);
		$this->addOkMessage('RegistrationRequest created');
		$this->view->assign('registrationRequest', $registrationRequest);
	}



}

?>
