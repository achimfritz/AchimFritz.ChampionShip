<?php
namespace AchimFritz\ChampionShip\ViewHelpers;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Fluid".                 *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 * of the License, or (at your option) any later version.                 *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Domain\Model\Match;
use AchimFritz\ChampionShip\Domain\Model\CrossGroupRoundMatch;


/**
 * 
 * Enter description here ...
 * @author af
 *
 */
class IfIsCrossGroupRoundMatchViewHelper extends \TYPO3\Fluid\Core\ViewHelper\AbstractConditionViewHelper {
	
	/**
	 * Renders <f:then> child if match is groupMatch is true, otherwise renders <f:else> child.
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\Match $match
	 * @return string the rendered string
	 */
	public function render(Match $match) {	
		if ($match instanceof CrossGroupRoundMatch) {
			return $this->renderThenChild();
		} else {
			return $this->renderElseChild();
		}
	}
}

?>