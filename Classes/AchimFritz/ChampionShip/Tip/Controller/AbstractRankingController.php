<?php
namespace AchimFritz\ChampionShip\Tip\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;


/**
 * Team controller for the AchimFritz.ChampionShip package 
 *
 * @Flow\Scope("singleton")
 */
class AbstractRankingController extends AbstractTipGroupController {

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\MatchRepository
	 */
	protected $matchRepository;


	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Tip\Domain\Factory\RankingsFactory
	 */
	protected $rankingsFactory;

	/**
	 * @var string
	 */
	protected $resourceArgumentName = 'tipGroup';

}

?>
