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
use AchimFritz\ChampionShip\Competition\Domain\Model\Match;
use AchimFritz\ChampionShip\Competition\Domain\Model\Round;
use AchimFritz\ChampionShip\Chat\Domain\Model\ChatEntry;

/**
 *
 * Enter description here ...
 * @author af
 *
 */
class RestUriViewHelper extends \TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper
{

    
    /**
     * NOTE: This property has been introduced via code migration to ensure backwards-compatibility.
     * @see AbstractViewHelper::isOutputEscapingEnabled()
     * @var boolean
     */
    protected $escapeOutput = false;

    /**
     * @var \TYPO3\Flow\Security\Context
     * @Flow\Inject
     */
    protected $securityContext;

    /**
     * render
     * @param object $object
     * @param string|NULL subpackage
     * @return string
     */
    public function render($object, $subpackage = null)
    {
        $name = get_class($object);
        $parts = explode('\\', $name);
        $model = array_pop($parts);
        if ($object instanceof Match) {
            $resource = 'match';
        } elseif ($object instanceof Round) {
            $resource = 'round';
        } elseif ($object instanceof ChatEntry) {
            $resource = 'chatEntry';
        } else {
            $resource = lcfirst($model);
        }
        // controller is same as model
        $controller = $model;
        // but not on groupRoundMatch
        $requestControllerName = $this->controllerContext->getRequest()->getControllerName();
        /*
        if ($requestControllerName == 'GroupRound' AND $resource == 'match') {
            $controller = 'GroupRoundMatch';
        } elseif ($requestControllerName == 'GroupMatch' AND $resource == 'match') {
            $controller = 'GroupRoundMatch';
        }
        */
        // and not in tip
        if ($resource == 'tip') {
            $role = 'AchimFritz.ChampionShip:Administrator';
            if ($this->securityContext->hasRole($role)) {
                $controller = 'AdminTip';
            } else {
                $controller = $requestControllerName;
            }
        }

        $action = 'index';
        $arguments = array($resource => $object);
        if ($this->controllerContext->getRequest()->hasArgument('cup')) {
            $arguments['cup'] = $this->controllerContext->getRequest()->getArgument('cup');
        }

        $uriBuilder = $this->controllerContext->getUriBuilder();
        $uriBuilder->reset();
        $uriBuilder->setCreateAbsoluteUri(true);

        $actionUri = $uriBuilder->uriFor($action, $arguments, $controller, null, $subpackage);
        return $actionUri;
    }
}
