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
	 * @var \AchimFritz\ChampionShip\Domain\Repository\RankingRepository
	 */
	protected $rankingRepository;

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Service\RankingCalculator
	 */
	protected $rankingCalculator;

	/**
	 * @var string
	 */
	protected $resourceArgumentName = 'cup';

	/**
	 * Shows a list of rankings
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\Cup $cup
	 * @return void
	 */
	public function showAction(Cup $cup) {
		$this->view->assign('rankings', $this->rankingRepository->findByCup($cup));
	}


	/**
	 * updateAction
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\Cup $cup
	 * @return void
	 */
	public function updateAction(Cup $cup) {
		$rankings = $this->rankingCalculator->updateCup($cup);
		$this->addOkMessage(count($rankings) . ' rankings updatet');
		$this->redirect('show', NULL, NULL, array('cup' => $cup));
	}


}

?>
