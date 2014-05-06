<?php
namespace AchimFritz\ChampionShip\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Domain\Model\TipGroup;
use AchimFritz\ChampionShip\Domain\Model\User;

class TipGroupKoRoundResultsController extends TipGroupResultsController {

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\KoMatchRepository
	 */
	protected $matchRepository;

}

?>
