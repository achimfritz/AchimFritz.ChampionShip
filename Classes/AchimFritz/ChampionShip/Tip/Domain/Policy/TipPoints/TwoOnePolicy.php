<?php
namespace AchimFritz\ChampionShip\Tip\Domain\Policy\TipPoints;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

/**
 * CalculateTipPointsPolicy
 *
 * @Flow\Scope("singleton")
 */
class TwoOnePolicy extends DefaultPolicy
{

    /**
     * @var integer
     */
    protected $exact = 2;

    /**
     * @var integer
     */
    protected $trend = 1;
}
