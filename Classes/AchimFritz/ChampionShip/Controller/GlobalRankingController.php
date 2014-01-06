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
class GlobalRankingController extends ActionController {

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
	 * Shows a list of rankings
	 *
	 * @return void
	 */
	public function listAction() {
		$rankings = $this->rankingRepository->findAllGroupByUser();
		foreach ($rankings AS $r) {
			#var_dump(get_class($r[0]));
		#	var_dump($r->getUser()->getName());
		}
		$this->view->assign('rankings', $rankings);
	}

}

?>
