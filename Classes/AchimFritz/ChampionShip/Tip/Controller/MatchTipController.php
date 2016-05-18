<?php
namespace AchimFritz\ChampionShip\Tip\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Competition\Domain\Model\Cup;
use AchimFritz\ChampionShip\Competition\Domain\Model\Match;


/**
 * Standard controller for the AchimFritz.ChampionShip package 
 *
 * @Flow\Scope("singleton")
 */
class MatchTipController extends AbstractActionController {

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\MatchRepository
	 */
	protected $matchRepository;

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Tip\Domain\Repository\TipRepository
	 */
	protected $tipRepository;

	/**
	 * @var string
	 */
	protected $resourceArgumentName = 'match';

	/**
	 * @param \AchimFritz\ChampionShip\Competition\Domain\Model\Cup $cup
	 */
	public function listAction(Cup $cup) {
		$matches = $this->matchRepository->findByCup($cup);
		$this->view->assign('matches', $matches);
	}

	/**
	 * showAction
	 *
	 * @param \AchimFritz\ChampionShip\Competition\Domain\Model\Match $match
	 */
	public function showAction(Match $match) {
		$tips = $this->tipRepository->findByGeneralMatch($match);
		$this->view->assign('tips', $tips);
		$this->view->assign('match', $match);
	}


}
