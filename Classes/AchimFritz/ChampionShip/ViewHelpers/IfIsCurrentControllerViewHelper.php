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
use AchimFritz\ChampionShip\Competition\Domain\Model\Round;
use AchimFritz\ChampionShip\Competition\Domain\Model\KoRound;
use AchimFritz\ChampionShip\Competition\Domain\Model\Cup;

/**
 *
 * Enter description here ...
 * @author af
 *
 */
class IfIsCurrentControllerViewHelper extends \TYPO3\Fluid\Core\ViewHelper\AbstractConditionViewHelper
{

    /**
     * @var \TYPO3\Flow\Persistence\PersistenceManagerInterface
     * @Flow\Inject
     */
    protected $persistenceManager;

    /**
     * Renders <f:then> child if match is groupMatch is true, otherwise renders <f:else> child.
     *
     * @param string $controllerName
     * @param string $action
     * @param Cup $cup
     * @return string the rendered string
     */
    public function render($controllerName, $action = '', $cup = null)
    {
        $requestControllerName = $this->controllerContext->getRequest()->getControllerName();
        $requestActionName = $this->controllerContext->getRequest()->getControllerActionName();
        $requestCup = null;
        if ($this->controllerContext->getRequest()->hasArgument('cup')) {
            $requestCup = $this->controllerContext->getRequest()->getArgument('cup');
        }

        $renderChild = false;
        if ($requestControllerName == $controllerName) {
            $renderChild = true;
        } else {
            if ($controllerName == 'GroupRound' and $requestControllerName == 'GroupRoundMatch') {
                $renderChild = true;
            }
            if ($controllerName == 'KoRound' and $requestControllerName == 'CrossGroupMatch') {
                $renderChild = true;
            }
            if ($controllerName == 'KoRound' and $requestControllerName == 'TeamsOfTwoMatchesMatch') {
                $renderChild = true;
            }
            if ($controllerName == 'OpenChatEntry' and $requestControllerName == 'TipGroupChatEntry') {
                $renderChild = true;
            }
        }
        if ($renderChild === true) {
            if ($cup === null && $action === '') {
                return $this->renderThenChild();
            } elseif ($cup !== null) {
                if ($this->persistenceManager->getIdentifierByObject($cup) === $requestCup['__identity']) {
                    return $this->renderThenChild();
                }
            } elseif ($action === $requestActionName) {
                return $this->renderThenChild();
            }
        }
        return $this->renderElseChild();
    }
}
