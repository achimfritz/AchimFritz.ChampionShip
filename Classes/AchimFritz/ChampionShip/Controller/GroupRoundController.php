<?php
namespace AchimFritz\ChampionShip\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

use \AchimFritz\ChampionShip\Domain\Model\GroupRound;

/**
 * GroupRound controller for the AchimFritz.ChampionShip package 
 *
 * @Flow\Scope("singleton")
 */
class GroupRoundController extends ActionController {

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\GroupRoundRepository
	 */
	protected $groupRoundRepository;


	/**
	 * Shows a single group round object
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\GroupRound $groupRound The group round to show
	 * @return void
	 */
	public function showAction(GroupRound $groupRound) {
		$this->view->assign('groupRound', $groupRound);
	}

	/**
	 * Shows a form for creating a new group round object
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\Cup
	 * @return void
	 */
	public function newAction(\AchimFritz\ChampionShip\Domain\Model\Cup $cup) {
		$this->view->assign('cup', $cup);
	}

	/**
	 * Adds the given new group round object to the group round repository
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\GroupRound $newGroupRound A new group round to add
	 * @return void
	 */
	public function createAction(GroupRound $newGroupRound) {
		try {
			$this->groupRoundRepository->add($newGroupRound);
			$this->persistenceManager->persistAll();
			$this->addOkMessage('round created');
		} catch (\Exception $e) {
			$this->addErrorMessage('cannot create round');
			$this->handleException($e);
		}
		$this->redirect('show', 'Cup', NULL, array('cup' => $newGroupRound->getCup()));
	}

	/**
	 * Shows a form for editing an existing group round object
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\GroupRound $groupRound The group round to edit
	 * @return void
	 */
	public function editAction(GroupRound $groupRound) {
		$this->view->assign('groupRound', $groupRound);
	}

	/**
	 * Updates the given group round object
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\GroupRound $groupRound The group round to update
	 * @return void
	 */
	public function updateAction(GroupRound $groupRound) {
		try {
			$this->groupRoundRepository->update($groupRound);
			$this->persistenceManager->persistAll();
			$this->addOkMessage('round updatet');
		} catch (\Exception $e) {
			$this->addErrorMessage('cannot update round');
			$this->handleException($e);
		}
		$this->redirect('show', 'Cup', NULL, array('cup' => $groupRound->getCup()));
	}

	/**
	 * Removes the given group round object from the group round repository
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\GroupRound $groupRound The group round to delete
	 * @return void
	 */
	public function deleteAction(GroupRound $groupRound) {
		try {
			$this->groupRoundRepository->remove($groupRound);
			$this->persistenceManager->persistAll();
			$this->addOkMessage('round deletet');
		} catch (\Exception $e) {
			$this->addErrorMessage('cannot delete round');
			$this->handleException($e);
		}
		$this->redirect('show', 'Cup', NULL, array('cup' => $groupRound->getCup()));
	}

}

?>