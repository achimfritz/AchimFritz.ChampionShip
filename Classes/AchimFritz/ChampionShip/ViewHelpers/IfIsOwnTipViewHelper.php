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
use AchimFritz\ChampionShip\Domain\Model\Tip;

/**
 * 
 * Enter description here ...
 * @author af
 *
 */
class IfIsOwnTipViewHelper extends \TYPO3\Fluid\Core\ViewHelper\AbstractConditionViewHelper {

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
	 * Renders <f:then> child if match is groupMatch is true, otherwise renders <f:else> child.
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\Tip $tip
	 * @return string the rendered string
	 */
	public function render(Tip $tip) {
		$account = $this->securityContext->getAccount();
		if ($account) {
			$user = $this->userRepository->findOneByAccount($account);
			if ($user === $tip->getUser()) {
				$now = new \DateTime();
				if ($now < $tip->getMatch()->getStartDate()) {
					return $this->renderThenChild();
				}
			}
		}
		return $this->renderElseChild();
	}
}

?>
