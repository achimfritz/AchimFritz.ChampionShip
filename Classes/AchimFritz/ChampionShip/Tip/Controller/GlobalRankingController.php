<?php
namespace AchimFritz\ChampionShip\Tip\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\User\Domain\Model\TipGroup;

/**
 * Team controller for the AchimFritz.ChampionShip package 
 *
 * @Flow\Scope("singleton")
 */
class GlobalRankingController extends AbstractTipGroupController {

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Tip\Domain\Repository\RankingRepository
	 */
	protected $rankingRepository;

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\User\Domain\Repository\UserRepository
	 */
	protected $userRepository;

	/**
	 * @var string
	 */
	protected $resourceArgumentName = 'tipGroup';

	/**
	 * listAction 
	 * 
	 * @return void
	 */
	public function listAction() {
		$rankings = $this->rankingRepository->findAll();
		$this->view->assign('rankings', $rankings);
	}

	/**
	 * Shows a list of rankings
	 *
	 * @param \AchimFritz\ChampionShip\User\Domain\Model\TipGroup $tipGroup
	 * @return void
	 */
	public function showAction(TipGroup $tipGroup) {
		$users = $this->userRepository->findInTipGroup($tipGroup);
		$rankings = $this->rankingRepository->findByUsers($users);
		$this->view->assign('rankings', $rankings);
		$this->view->assign('tipGroup', $tipGroup);
	}

}

?>
