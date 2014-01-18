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
use TYPO3\Fluid\ViewHelpers\FormViewHelper;

/**
 * 
 * Enter description here ...
 * @author af
 *
 */
class RestUriViewHelper extends \TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * render
	 * @param object $object
	 * @return string
	 */
	public function render($object) {
		$name = get_class($object);
		$parts = explode('\\', $name);
		$model = array_pop($parts);
		return $model;
		$name = lcfirst($controller);
		$name = 'match';
		// TODO

		$action = 'index';
		$arguments = array($name => $object);

		$uriBuilder = $this->controllerContext->getUriBuilder();
		$uriBuilder->reset();
		$uriBuilder->setCreateAbsoluteUri(TRUE);
		$actionUri = $uriBuilder->uriFor($action, $arguments, $controller);
		return $actionUri;
	}
}

?>
