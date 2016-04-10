<?php
namespace AchimFritz\ChampionShip\Chat\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Chat\Domain\Model\TipGroupChatEntry;
use AchimFritz\ChampionShip\Tip\Domain\Model\TipGroup;

class TipGroupChatEntryController extends AbstractChatEntryController {

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Chat\Domain\Repository\TipGroupChatEntryRepository
	 */
	protected $chatEntryRepository;

	/**
	 * Shows a list of rankings
	 *
	 * @param \AchimFritz\ChampionShip\Tip\Domain\Model\TipGroup $tipGroup
	 * @return void
	 */
	public function listAction(TipGroup $tipGroup) {
		$this->view->assign('chatEntries', $this->chatEntryRepository->findByTipGroup($tipGroup));
		$this->view->assign('tipGroup', $tipGroup);
	}

	/**
	 * @param \AchimFritz\ChampionShip\Chat\Domain\Model\TipGroupChatEntry $chatEntry
	 * @return void
	 */
	public function showAction(TipGroupChatEntry $chatEntry) {
		$this->view->assign('chatEntry', $chatEntry);
	}

	/**
	 * @param \AchimFritz\ChampionShip\Chat\Domain\Model\TipGroupChatEntry $chatEntry
	 * @return void
	 */
	public function createAction(TipGroupChatEntry $chatEntry) {
		$this->createChatEntry($chatEntry);
		$this->redirect('index', NULL, NULL, array('tipGroup' => $chatEntry->getTipGroup()));
	}

	/**
	 * @param \AchimFritz\ChampionShip\Chat\Domain\Model\TipGroupChatEntry $chatEntry
	 * @return void
	 */
	public function updateAction(TipGroupChatEntry $chatEntry) {
		$this->updateChatEntry($chatEntry);
		$this->redirect('index', NULL, NULL, array('tipGroup' => $chatEntry->getTipGroup()));
	}

	/**
	 * @param \AchimFritz\ChampionShip\Chat\Domain\Model\TipGroupChatEntry $chatEntry
	 * @return void
	 */
	public function deleteAction(TipGroupChatEntry $chatEntry) {
		$this->deleteChatEntry($chatEntry);
		$this->redirect('index', NULL, NULL, array('tipGroup' => $chatEntry->getTipGroup()));
	}


}

?>
