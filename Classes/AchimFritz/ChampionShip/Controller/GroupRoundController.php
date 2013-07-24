<?php
namespace AchimFritz\ChampionShip\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

use \AchimFritz\ChampionShip\Domain\Model\GroupRound;
use \AchimFritz\ChampionShip\Domain\Model\Cup;

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
	 * @var \AchimFritz\ChampionShip\Domain\Service\GroupRoundService
	 * @Flow\Inject
	 */
	protected $groupRoundService;
	
	/**
	 * @var string
	 */
	protected $resourceArgumentName = 'groupRound';

	/**
	 * listAction
	 * 
	 * @param \AchimFritz\ChampionShip\Domain\Model\Cup $cup
	 */
	public function listAction(Cup $cup) {
		$groupRounds = $this->groupRoundRepository->findByCup($cup);
		$this->view->assign('groupRounds', $groupRounds);
	}

	/**
	 * showAction
	 * 
	 * @param \AchimFritz\ChampionShip\Domain\Model\GroupRound $groupRound
	 */
	public function showAction(GroupRound $groupRound) {
		$this->view->assign('groupRound', $groupRound);
	}

	/**
	 * Adds the given new group round object to the group round repository
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\GroupRound $groupRound A new group round to add
	 * @return void
	 */
	public function createAction(GroupRound $groupRound) {
		try {
			$this->groupRoundRepository->add($groupRound);
			$this->persistenceManager->persistAll();
			$this->addOkMessage('round created');
		} catch (\Exception $e) {
			$this->addErrorMessage('cannot create round');
			$this->handleException($e);
		}
		$this->redirect('list', 'GroupRound', NULL, array('cup' => $groupRound->getCup(), 'groupRound' => $groupRound));
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
		$this->redirect('show', 'GroupRound', NULL, array('cup' => $groupRound->getCup(), 'groupRound' => $groupRound));
	}

	/**
	 * Removes the given group round object from the group round repository
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\GroupRound $groupRound The group round to delete
	 * @return void
	 */
	public function deleteAction(GroupRound $groupRound) {
		$cup = $groupRound->getCup();
		try {
			$this->groupRoundRepository->remove($groupRound);
			$this->persistenceManager->persistAll();
			$this->addOkMessage('round deletet');
		} catch (\Exception $e) {
			$this->addErrorMessage('cannot delete round');
			$this->handleException($e);
		}
		$this->redirect('list', 'GroupRound', NULL, array('cup' => $cup));
	}
	
	/**
	 * createMatchesAction
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\GroupRound $groupRound The group round to update
	 * @return void
	 */
	public function createMatchesAction(GroupRound $groupRound) {
		// TODO
		try {
			$this->groupRoundService->updateMatches($groupRound);
			$this->groupRoundRepository->update($groupRound);
			$this->persistenceManager->persistAll();
			$this->addOkMessage('matches created');
		} catch (\Exception $e) {
			$this->addErrorMessage('cannot update round');
			$this->handleException($e);
		}
		$this->redirect('list', 'GroupRound', NULL, array('cup' => $groupRound->getCup(), 'groupRound' => $groupRound));
	}
	
	/**
	 * updateGroupTableAction
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\GroupRound $groupRound The group round to update
	 * @return void
	 */
	public function updateGroupTableAction(GroupRound $groupRound) {
		// TODO
		try {
			$this->groupRoundService->updateGroupTable($groupRound);
			$this->groupRoundRepository->update($groupRound);
			$this->persistenceManager->persistAll();
			$this->addOkMessage('GroupTable updatet');
		} catch (\Exception $e) {
			$this->addErrorMessage('cannot update round');
			$this->handleException($e);
		}
		$this->redirect('list', 'GroupRound', NULL, array('cup' => $groupRound->getCup(), 'groupRound' => $groupRound));
	}

}

?>
