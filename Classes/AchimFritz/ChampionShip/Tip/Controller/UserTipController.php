<?php
namespace AchimFritz\ChampionShip\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use \AchimFritz\ChampionShip\Domain\Model\Tip;
use \AchimFritz\ChampionShip\Competition\Domain\Model\Match;
use \AchimFritz\ChampionShip\Domain\Model\User;
use \AchimFritz\ChampionShip\Competition\Domain\Model\Cup;

/**
 * Standard controller for the AchimFritz.ChampionShip package 
 *
 * @Flow\Scope("singleton")
 */
class UserTipController extends TipController {

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\MatchRepository
	 */
	protected $matchRepository;

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Factory\TipFactory
	 */
	protected $tipFactory;


}

?>
