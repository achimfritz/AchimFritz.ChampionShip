<?php
namespace AchimFritz\ChampionShip\Competition\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */


use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Competition\Domain\Model\ExtraPoints;

class ExtraPointsController extends AbstractActionController {

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\ExtraPointsRepository
	 */
	protected $extraPointsRepository;

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\TeamRepository
	 */
	protected $teamRepository;

	/**
	 * @var string
	 */
	protected $resourceArgumentName = 'extraPoints';

	/**
	 * @return void
	 */
	public function listAction() {
		$this->view->assign('allTeams', $this->teamRepository->findAll());
		$this->view->assign('extraPoints', $this->extraPointsRepository->findAll());
	}

	/**
	 * @param \AchimFritz\ChampionShip\Competition\Domain\Model\ExtraPoints $extraPoints
	 * @return void
	 */
	public function showAction(ExtraPoints $extraPoints) {
		$cups = $this->cupRepository->findAll();
		$this->view->assign('cups', $cups);
		$this->view->assign('allTeams', $this->teamRepository->findAll());
		$this->view->assign('extraPoints', $extraPoints);
	}

	/**
	 * @param \AchimFritz\ChampionShip\Competition\Domain\Model\ExtraPoints $extraPoints
	 * @return void
	 */
	public function createAction(ExtraPoints $extraPoints) {
		$this->extraPointsRepository->add($extraPoints);
		$this->addFlashMessage('Created a new extra points.');
		$this->redirect('list');
	}

	/**
	 * @param \AchimFritz\ChampionShip\Competition\Domain\Model\ExtraPoints $extraPoints
	 * @return void
	 */
	public function updateAction(ExtraPoints $extraPoints) {
		$this->extraPointsRepository->update($extraPoints);
		$this->addFlashMessage('Updated the extra points.');
		$this->redirect('list');
	}

	/**
	 * @param \AchimFritz\ChampionShip\Competition\Domain\Model\ExtraPoints $extraPoints
	 * @return void
	 */
	public function deleteAction(ExtraPoints $extraPoints) {
		$this->extraPointsRepository->remove($extraPoints);
		$this->addFlashMessage('Deleted a extra points.');
		$this->redirect('list');
	}

}
