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
use AchimFritz\ChampionShip\Tip\Domain\Model\Tip;

/**
 *
 * Enter description here ...
 * @author af
 *
 */
class IfActionIsAllowedViewHelper extends \Neos\FluidAdaptor\Core\ViewHelper\AbstractConditionViewHelper
{
    
    /**
     * @var \Neos\Flow\Security\Context
     * @Flow\Inject
     */
    protected $securityContext;

    /**
     * Renders <f:then> child if match is groupMatch is true, otherwise renders <f:else> child.
     *
     * @param object $object
     * @return string the rendered string
     */
    public function render($object)
    {
        $role = 'AchimFritz.ChampionShip:Administrator';
        if ($this->securityContext->hasRole($role)) {
            return $this->renderThenChild();
        } else {
            if ($object instanceof Tip) {
                $role = 'AchimFritz.ChampionShip:User';
                if ($this->securityContext->hasRole($role)) {
                    return $this->renderThenChild();
                }
            }
        }
        return $this->renderElseChild();
    }
}
