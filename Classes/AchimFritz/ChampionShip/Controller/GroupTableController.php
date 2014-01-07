<?php
namespace AchimFritz\ChampionShip\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

use AchimFritz\ChampionShip\Domain\Model\GroupRound;

/**
 * Team controller for the AchimFritz.ChampionShip package 
 *
 * @Flow\Scope("singleton")
 */
class GroupTableController extends ActionController {

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\GroupRoundRepository
	 */
	protected $roundRepository;

	/**
	 * @var \AchimFritz\ChampionShip\Domain\Service\GroupRoundService
	 * @Flow\Inject
	 */
	protected $groupRoundService;
	
	/**
	 * @var string
	 */
	protected $resourceArgumentName = 'groupRound';

	/**
	 * Updates the given team object
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\GroupRound $groupRound
	 * @return void
	 */
	public function updateAction(GroupRound $groupRound) {
		try {
			$this->groupRoundService->updateGroupTable($groupRound);
			$this->roundRepository->update($groupRound);
			$this->persistenceManager->persistAll();
			$this->addOkMessage('groupTable updatet');
		} catch (\Exception $e) {
			$this->addErrorMessage('cannot update groupTable');
			$this->handleException($e);
		}
		$this->redirect('index', 'GroupRound', NULL, array('round' => $groupRound, 'cup' => $groupRound->getCup()));
	}


}

?>
