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

use AchimFritz\ChampionShip\Competition\Domain\Model\Cup;
use TYPO3\Flow\Annotations as Flow;

/**
 * 
 * Enter description here ...
 * @author af
 *
 */
class CurrentMatchesViewHelper extends \TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper {

	
	/**
	 * NOTE: This property has been introduced via code migration to ensure backwards-compatibility.
	 * @see AbstractViewHelper::isOutputEscapingEnabled()
	 * @var boolean
	 */
	protected $escapeOutput = FALSE;

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\MatchRepository
	 */
	protected $matchRepository;


	/**
	 * @param \AchimFritz\ChampionShip\Competition\Domain\Model\Cup $cup
	 * @param integer $limit
	 * @param boolean $past
	 * @return void
	 */
	public function render(Cup $cup, $limit = 2, $past = TRUE) {
		if ($past === TRUE) {
			$matches = $this->matchRepository->findLastByCup($cup, $limit);
		} else {
			$matches = $this->matchRepository->findNextByCup($cup, $limit);
		}
		$this->templateVariableContainer->add('matches', $matches);
		$out = $this->renderChildren();
		$this->templateVariableContainer->remove('matches');
		return $out;


	}
}

