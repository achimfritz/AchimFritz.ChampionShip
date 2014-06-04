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
class AbstractRankingController extends AbstractTipGroupController {

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\MatchRepository
	 */
	protected $matchRepository;


	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Factory\RankingsFactory
	 */
	protected $rankingsFactory;

	/**
	 * @var string
	 */
	protected $resourceArgumentName = 'tipGroup';

}

?>
