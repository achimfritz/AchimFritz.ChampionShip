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
	 * @var string
	 */
	protected $resourceArgumentName = 'round';

	/**
	 * Updates the given team object
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\GroupRound $groupRound
	 * @return void
	 */
	public function updateAction(GroupRound $groupRound) {
	/*
		try {
			$this->teamRepository->update($team);
			$this->persistenceManager->persistAll();
			$this->addOkMessage('team updated');
		} catch (\Exception $e) {
			$this->addErrorMessage('cannot update team');
			$this->handleException($e);
		}
		$this->redirect('index', 'Team', NULL, array('team' => $team));
*/
	}


}

?>
