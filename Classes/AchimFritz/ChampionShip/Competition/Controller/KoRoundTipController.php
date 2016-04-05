<?php
namespace AchimFritz\ChampionShip\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use \AchimFritz\ChampionShip\Domain\Model\Round;
use \AchimFritz\ChampionShip\Domain\Model\Cup;

/**
 * GroupRound controller for the AchimFritz.ChampionShip package 
 *
 * @Flow\Scope("singleton")
 */
class KoRoundTipController extends UserTipController {

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\KoRoundRepository
	 */
	protected $roundRepository;
	
	/**
	 * showAction
	 * 
	 * @param \AchimFritz\ChampionShip\Domain\Model\Round $round
	 */
	public function listAction(Round $round = NULL) {
		if ($round === NULL) {
			$round = $this->roundRepository->findOneByCup($this->cup);
		}
		if ($round instanceof Round) {
			$tips = $this->tipRepository->findByUserInRound($this->user, $round);
			$this->view->assign('tips', $tips);
			$this->view->assign('round', $round);
			$this->view->assign('allRounds', $this->roundRepository->findByCup($round->getCup()));
		} else {
			$this->addErrorMessage('no rounds found');
		}

	}


}

?>
