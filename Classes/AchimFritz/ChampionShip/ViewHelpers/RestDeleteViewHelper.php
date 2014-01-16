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
class RestDeleteViewHelper extends \TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * @var \TYPO3\Fluid\ViewHelpers\FormViewHelper
	 * @Flow\Inject
	 */
	protected $formViewHelper;

	/**
	 * render
	 * @param object $object
	 * @return strint
	 */
	public function render($object) {
		$controller = 'GroupMatch';
		$action = 'index';
		//$arguments = array

		$uriBuilder = $this->controllerContext->getUriBuilder();
		$uriBuilder->reset();
		$actionUri = $uriBuilder->uriFor($action, array(), $controller);
		$request = $this->controllerContext->getRequest();
		return 'dfsadfsf';

		$this->formViewHelper->setArguments(array('actionUri' => $actionUri, 'method' => 'POST', 'fieldNamePrefix' => $request->getArgumentNamespace()));

#var_dump($actionUri);
#var_dump('xxx');

		//return $actionUri;

/*
public function render($action = NULL, array $arguments = array(), $controller = NULL, $package = NULL, $subpackage = NULL, $object = NULL, $section = '', $format = '', array $additionalParams = array(), $absolute = FALSE, $addQueryString = FALSE, array $argumentsToBeExcludedFromQueryString = array(), $fieldNamePrefix = NULL, $actionUri = NULL, $objectName = NULL, $useParentRequest = FALSE)
*/


		$content = 'xxx' . $this->formViewHelper->render(NULL, array(), NULL, NULL, NULL, NULL, '', '', array(), FALSE, FALSE, array(), NULL, $actionUri);
		return $content;

		return 'cxsfasdf';
	}
}

?>
