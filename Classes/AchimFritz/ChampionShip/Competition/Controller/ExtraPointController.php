<?php
namespace AchimFritz\ChampionShip\Competition\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */


use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Competition\Domain\Model\ExtraPoint;

class ExtraPointController extends AbstractActionController {

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\ExtraPointRepository
	 */
	protected $extraPointRepository;

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\TeamRepository
	 */
	protected $teamRepository;

	/**
	 * @var string
	 */
	protected $resourceArgumentName = 'extraPoint';

	/**
	 * @return void
	 */
	public function listAction() {
		$this->view->assign('allTeams', $this->teamRepository->findAll());
		$this->view->assign('extraPoints', $this->extraPointRepository->findAll());
	}

	/**
	 * @param \AchimFritz\ChampionShip\Competition\Domain\Model\ExtraPoint $extraPoint
	 * @return void
	 */
	public function showAction(ExtraPoint $extraPoint) {
		$cups = $this->cupRepository->findAll();
		$this->view->assign('cups', $cups);
		$this->view->assign('allTeams', $this->teamRepository->findAll());
		$this->view->assign('extraPoint', $extraPoint);
	}

	/**
	 * @param \AchimFritz\ChampionShip\Competition\Domain\Model\ExtraPoint $extraPoint
	 * @return void
	 */
	public function createAction(ExtraPoint $extraPoint) {
		$this->extraPointRepository->add($extraPoint);
		$this->addFlashMessage('Created a new extra points.');
		$this->redirect('list');
	}

	/**
	 * @param \AchimFritz\ChampionShip\Competition\Domain\Model\ExtraPoint $extraPoint
	 * @return void
	 */
	public function updateAction(ExtraPoint $extraPoint) {
		$this->extraPointRepository->update($extraPoint);
		$this->addFlashMessage('Updated the extra points.');
		$this->redirect('list');
	}

	/**
	 * @param \AchimFritz\ChampionShip\Competition\Domain\Model\ExtraPoint $extraPoint
	 * @return void
	 */
	public function deleteAction(ExtraPoint $extraPoint) {
		$this->extraPointRepository->remove($extraPoint);
		$this->addFlashMessage('Deleted a extra points.');
		$this->redirect('list');
	}

}
