<?php
namespace AchimFritz\ChampionShip\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

use AchimFritz\ChampionShip\Domain\Model\Ranking;
use AchimFritz\ChampionShip\Domain\Model\Cup;

/**
 * Team controller for the AchimFritz.ChampionShip package 
 *
 * @Flow\Scope("singleton")
 */
class RankingController extends ActionController {

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Factory\RankingsFactory
	 */
	protected $rankingsFactory;

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\MatchRepository
	 */
	protected $matchRepository;

	/**
	 * @var string
	 */
	protected $resourceArgumentName = 'cup';

	/**
	 * listAction 
	 * 
	 * @return void
	 */
	public function listAction() {
		$matches = $this->matchRepository->findAll();
		$rankings = $this->rankingsFactory->create($matches);
		$this->view->assign('rankings', $rankings);
	}

	/**
	 * Shows a list of rankings
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\Cup $cup
	 * @return void
	 */
	public function showAction(Cup $cup) {
		$matches = $this->matchRepository->findByCup($cup);
		$rankings = $this->rankingsFactory->create($matches);
		$this->view->assign('rankings', $rankings);
	}

}

?>
