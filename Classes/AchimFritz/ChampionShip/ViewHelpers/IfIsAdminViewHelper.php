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

/**
 * 
 * Enter description here ...
 * @author af
 *
 */
class IfIsAdminViewHelper extends \TYPO3\Fluid\Core\ViewHelper\AbstractConditionViewHelper {
	
	/**
	 * @var \TYPO3\Flow\Security\Context
	 * @Flow\Inject
	 */
	protected $securityContext;
	
	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\Security\Policy\PolicyService
	 */
	protected $policyService;

	/**
	 * Renders <f:then> child if $condition is true, otherwise renders <f:else> child.
	 *
	 * @param boolean $condition View helper condition
	 * @return string the rendered string
	 * @api
	 */
	public function render() {	
		$tokens = $this->securityContext->getAuthenticationTokens();
		$admin = FALSE;
		foreach ($tokens as $token) {
			if ($token->isAuthenticated()) {
				$account = $token->getAccount();
				$adminRole = $this->policyService->getRole('AchimFritz.ChampionShip:Administrator');
				if ($account->hasRole($adminRole)) {
					$admin = TRUE;
				}
			}
		}
		
		if ($admin === TRUE) {
			return $this->renderThenChild();
		} else {
			return $this->renderElseChild();
		}
	}
}

?>