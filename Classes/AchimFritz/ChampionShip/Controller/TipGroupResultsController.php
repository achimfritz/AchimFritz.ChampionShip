<?php
namespace AchimFritz\ChampionShip\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Domain\Model\TipGroup;
use AchimFritz\ChampionShip\Domain\Model\User;

class TipGroupResultsController extends ActionController {

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\TipGroupRepository
	 */
	protected $tipGroupRepository;

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\UserRepository
	 */
	protected $userRepository;

	/**
	 * @var \AchimFritz\ChampionShip\Domain\Model\User
	 */
	protected $user;

	/**
	 * @var \TYPO3\Flow\Security\Context
	 * @Flow\Inject
	 */
	protected $securityContext;

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\MatchRepository
	 */
	protected $matchRepository;

	/**
	 * @var \AchimFritz\ChampionShip\Domain\Factory\TipGroupResultMatrixFactory
	 * @Flow\Inject
	 */
	protected $matrixFactory;

	/**
	 * @var string
	 */
	protected $resourceArgumentName = 'tipGroup';

	/**
	 * initializeAction
	 * 
	 * @return void
	 */
	protected function initializeAction() {
		parent::initializeAction();
		$account = $this->securityContext->getAccount();
		$this->user = $this->userRepository->findOneByAccount($account);
	}

	/**
	 * initializeView 
	 * 
	 * @return void
	 */
	protected function initializeView(\TYPO3\Flow\Mvc\View\ViewInterface $view) {
		parent::initializeView($view);
		if ($this->user instanceof User) {
			$this->view->assign('tipGroups', $this->user->getTipGroups());
		} else {
			// admin only
			$this->view->assign('tipGroups', $this->tipGroupRepository->findAll());
		}
	}

	/**
	 * listAction
	 *
	 * @return void
	 */
	public function listAction() {
		if ($this->user instanceof User) {
			$tipGroup = $this->user->getTipGroup();
		} else {
			// admin only
			$tipGroup = $this->tipGroupRepository->findAll()->getFirst();
		}
		$this->forward('show', NULL, NULL, array('tipGroup' => $tipGroup, 'cup' => $this->cup));
	}

	/**
	 * showAction
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\TipGroup $tipGroup
	 * @return void
	 */
	public function showAction(TipGroup $tipGroup) {
		$users = $this->userRepository->findInTipGroup($tipGroup);
		$matches = $this->matchRepository->findByCup($this->cup);
		$matrix = $this->matrixFactory->create($users, $matches);
		$this->view->assign('matrix', $matrix);
		$this->view->assign('tipGroup', $tipGroup);
	}

}

?>
