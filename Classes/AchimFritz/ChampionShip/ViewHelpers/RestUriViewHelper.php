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
use AchimFritz\ChampionShip\Domain\Model\Round;

/**
 * 
 * Enter description here ...
 * @author af
 *
 */
class RestUriViewHelper extends \TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * @var \TYPO3\Flow\Security\Context
	 * @Flow\Inject
	 */
	protected $securityContext;

	/**
	 * render
	 * @param object $object
	 * @return string
	 */
	public function render($object) {
		$name = get_class($object);
		$parts = explode('\\', $name);
		$model = array_pop($parts);
		if ($object instanceof Match) {
			$resource = 'match';
		} elseif ($object instanceof Round){
			$resource = 'round';
		} else {
			$resource = lcfirst($model);
		}
		// controller is same as model
		$controller = $model;
		// but not on groupRoundMatch
		$requestControllerName = $this->controllerContext->getRequest()->getControllerName();
		if ($requestControllerName == 'GroupRound' AND $resource == 'match') {
			$controller = 'GroupRoundMatch';
		}
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

		$uriBuilder = $this->controllerContext->getUriBuilder();
		$uriBuilder->reset();
		$uriBuilder->setCreateAbsoluteUri(TRUE);
		$actionUri = $uriBuilder->uriFor($action, $arguments, $controller);
		return $actionUri;
	}
}

?>
