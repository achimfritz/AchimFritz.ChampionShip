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
	 * @var \AchimFritz\ChampionShip\Domain\Repository\UserRepository
	 */
	protected $userRepository;

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
		$this->view->assign('allUsers', $this->userRepository->findAll());
		$this->view->assign('tipGroups', $this->tipGroupRepository->findAll());
	}

	/**
	 * @param \AchimFritz\ChampionShip\Domain\Model\TipGroup $tipGroup
	 * @return void
	 */
	public function showAction(TipGroup $tipGroup) {
		$this->view->assign('allUsers', $this->userRepository->findAll());
		$this->view->assign('tipGroup', $tipGroup);
	}

	/**
	 * @param \AchimFritz\ChampionShip\Domain\Model\TipGroup $tipGroup
	 * @return void
	 */
	public function createAction(TipGroup $tipGroup) {
		try {
			$this->tipGroupRepository->add($tipGroup);
			$this->persistenceManager->persistAll();
			$this->addOkMessage('tipGroup created');
		} catch (\Exception $e) {
			$this->addErrorMessage('cannot create tipGroup');
			$this->handleException($e);
		}		
		$this->redirect('index');
	}

	/**
	 * @param \AchimFritz\ChampionShip\Domain\Model\TipGroup $tipGroup
	 * @return void
	 */
	public function updateAction(TipGroup $tipGroup) {
		try {
			$this->tipGroupRepository->update($tipGroup);
			$this->persistenceManager->persistAll();
			$this->addOkMessage('tipGroup updated');
		} catch (\Exception $e) {
			$this->addErrorMessage('cannot update tipGroup');
			$this->handleException($e);
		}		
		$this->redirect('index');
	}

	/**
	 * @param \AchimFritz\ChampionShip\Domain\Model\TipGroup $tipGroup
	 * @return void
	 */
	public function deleteAction(TipGroup $tipGroup) {
		try {
			$this->tipGroupRepository->remove($tipGroup);
			$this->persistenceManager->persistAll();
			$this->addOkMessage('tipGroup deleted');
		} catch (\Exception $e) {
			$this->addErrorMessage('cannot delete tipGroup');
			$this->handleException($e);
		}		
		$this->redirect('index');
	}

}

?>
