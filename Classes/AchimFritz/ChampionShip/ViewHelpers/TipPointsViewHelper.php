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
use AchimFritz\ChampionShip\Tip\Domain\Model\Tip;

/**
 *
 * Enter description here ...
 * @author af
 *
 */
class TipPointsViewHelper extends \TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper
{

    
    /**
     * NOTE: This property has been introduced via code migration to ensure backwards-compatibility.
     * @see AbstractViewHelper::isOutputEscapingEnabled()
     * @var boolean
     */
    protected $escapeOutput = false;

    /**
     * render
     *
     * @param Tip $tip
     * @return string
     */
    public function render(Tip $tip)
    {
        if ($tip->getPoints() == 2) {
            return '<span class="icon-circle-arrow-up"></span>';
        } elseif ($tip->getPoints() == 1) {
            return '<span class="icon-circle-arrow-right"></span>';
        } else {
            return '';
        }
    }
}
