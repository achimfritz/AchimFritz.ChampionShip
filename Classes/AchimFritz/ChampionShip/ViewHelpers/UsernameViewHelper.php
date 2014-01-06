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
class UsernameViewHelper extends \TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * @var \TYPO3\Flow\Security\Context
	 * @Flow\Inject
	 */
	protected $securityContext;

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\UserRepository
	 */
	protected $userRepository;

	
	/**
	 * Renders username
	 *
	 * @return string the rendered string
	 */
	public function render() {	
		$account = $this->securityContext->getAccount();
		if ($account) {
			$user = $this->userRepository->findOneByAccount($account);
			if ($user) {
				return $user->getName();
			}
		}
		return '';
	}
}

?>
