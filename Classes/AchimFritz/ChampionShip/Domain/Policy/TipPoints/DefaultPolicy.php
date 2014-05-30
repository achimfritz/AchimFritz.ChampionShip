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
 * TipPolicy
 *
 * @Flow\Scope("singleton")
 */
class DefaultPolicy {

	/**
	 * @var integer
	 */
	protected $exact = 2;

	/**
	 * @var integer
	 */
	protected $trend = 1;

	/**
	 * isEditable
	 * 
	 * @param Tip $tip 
	 * @return integer
	 */
	public function getPointsForTip(Tip $tip) {
		$matchResult = $tip->getMatch()->getResult();
		if (!$matchResult instanceof Result) {
			return 0;
		}
		$result = $tip->getResult();
		if (!$result instanceof Result) {
			return 0;
		}
		$matchHostPoints = $matchResult->getHostPoints();
		$hostPoints = $result->getHostPoints();
		if ($matchHostPoints == $hostPoints) {
			if ($result->getHostTeamGoals() == $matchResult->getHostTeamGoals() AND 
				$result->getGuestTeamGoals() == $matchResult->getGuestTeamGoals()) {
				return $this->exact;
			}
			return $this->trend;
		}
		return 0;
	}

}
?>
