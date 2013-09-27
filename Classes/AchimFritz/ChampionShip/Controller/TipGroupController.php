<?php
namespace AchimFritz\ChampionShip\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Domain\Model\TipGroup;

class TipGroupController extends ActionController {

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\TipGroupRepository
	 */
	protected $tipGroupRepository;

	/**
	 * @var string
	 */
	protected $resourceArgumentName = 'tipGroup';

	/**
	 * @return void
	 */
	public function listAction() {
		$this->view->assign('tipGroups', $this->tipGroupRepository->findAll());
	}

	/**
	 * @param \AchimFritz\ChampionShip\Domain\Model\TipGroup $tipGroup
	 * @return void
	 */
	public function showAction(TipGroup $tipGroup) {
		$this->view->assign('tipGroup', $tipGroup);
	}

	/**
	 * @return void
	 */
	public function newAction() {
	}

	/**
	 * @param \AchimFritz\ChampionShip\Domain\Model\TipGroup $newTipGroup
	 * @return void
	 */
	public function createAction(TipGroup $newTipGroup) {
		$this->tipGroupRepository->add($newTipGroup);
		$this->addFlashMessage('Created a new tip group.');
		$this->redirect('index');
	}

	/**
	 * @param \AchimFritz\ChampionShip\Domain\Model\TipGroup $tipGroup
	 * @return void
	 */
	public function editAction(TipGroup $tipGroup) {
		$this->view->assign('tipGroup', $tipGroup);
	}

	/**
	 * @param \AchimFritz\ChampionShip\Domain\Model\TipGroup $tipGroup
	 * @return void
	 */
	public function updateAction(TipGroup $tipGroup) {
		$this->tipGroupRepository->update($tipGroup);
		$this->addFlashMessage('Updated the tip group.');
		$this->redirect('index');
	}

	/**
	 * @param \AchimFritz\ChampionShip\Domain\Model\TipGroup $tipGroup
	 * @return void
	 */
	public function deleteAction(TipGroup $tipGroup) {
		$this->tipGroupRepository->remove($tipGroup);
		$this->addFlashMessage('Deleted a tip group.');
		$this->redirect('index');
	}

}

?>
