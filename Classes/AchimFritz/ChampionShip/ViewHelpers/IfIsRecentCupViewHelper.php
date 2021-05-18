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

use Neos\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Competition\Domain\Model\Cup;

/**
 *
 * Enter description here ...
 * @author af
 *
 */
class IfIsRecentCupViewHelper extends \Neos\FluidAdaptor\Core\ViewHelper\AbstractConditionViewHelper
{

    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\CupRepository
     */
    protected $cupRepository;

    /**
     * Renders <f:then> child if match is groupMatch is true, otherwise renders <f:else> child.
     *
     * @param Cup $cup
     * @return string the rendered string
     */
    public function render($cup)
    {
        $recentCup = $this->cupRepository->findOneRecent();
        if ($recentCup === $cup) {
            return $this->renderThenChild();
        } else {
            return $this->renderElseChild();
        }
    }
}
