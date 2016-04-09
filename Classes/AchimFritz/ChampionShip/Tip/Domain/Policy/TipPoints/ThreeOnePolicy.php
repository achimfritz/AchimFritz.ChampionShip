<?php
namespace AchimFritz\ChampionShip\Domain\Policy\TipPoints;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Domain\Model\Tip;
use AchimFritz\ChampionShip\Domain\Model\Result;

/**
 * CalculateTipPointsPolicy
 *
 * @Flow\Scope("singleton")
 */
class ThreeOnePolicy extends DefaultPolicy {

	/**
	 * @var integer
	 */
	protected $exact = 3;

	/**
	 * @var integer
	 */
	protected $trend = 1;

}
?>
