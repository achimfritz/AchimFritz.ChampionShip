<?php
namespace AchimFritz\ChampionShip\Tip\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use Neos\Flow\Annotations as Flow;

class TipGroupGroupRoundResultsController extends AbstractTipGroupResultsController
{

    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\GroupMatchRepository
     */
    protected $matchRepository;
}
