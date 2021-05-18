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
use Neos\Flow\Reflection\ClassReflection;

/**
 *
 * Enter description here ...
 * @author af
 *
 */
class CupPolicyOptionsViewHelper extends \Neos\FluidAdaptor\Core\ViewHelper\AbstractViewHelper
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
     * workaround for http://lists.typo3.org/pipermail/typo3-project-typo3v4mvc/2011-May/009509.html
     * @param string $prefix
     * @return array
     */
    public function render($prefix)
    {
        $classReflection = new ClassReflection('AchimFritz\ChampionShip\Competition\Domain\Model\Cup');
        $constants = $classReflection->getConstants();
        $options = array();
        foreach ($constants as $name => $val) {
            if (strpos($name, $prefix) !== false) {
                $name = str_replace($prefix . '_', '', $name);
                $options[$val] = $name;
            }
        }
        return $options;
    }
}
