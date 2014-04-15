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
use AchimFritz\ChampionShip\Domain\Model\Result;


/**
 * 
 * Enter description here ...
 * @author af
 *
 */
class UserTipViewHelper extends \TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * @var \AchimFritz\ChampionShip\Domain\Repository\TipRepository
	 * @Flow\Inject
	 */
	protected $tipRepository;

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
	 * @Flow\Inject
	 * @var \TYPO3\Flow\Security\Policy\PolicyService
	 */
	protected $policyService;

	/**
	 * render
	 *
	 * @param Match $match
	 * @return string
	 */
	public function render(Match $match) {
		$userRole = $this->policyService->getRole('AchimFritz.ChampionShip:User');
		$account = $this->securityContext->getAccount();
		if ($account) {
			$user = $this->userRepository->findOneByAccount($account);
			$tip = $this->tipRepository->findOneByUserAndMatch($user, $match);
			if ($tip->getResult() instanceof Result) {
				return 'TODO';
			}
		return 'TODO';
			/*
			if ($user === $tip->getUser()) {
				$now = new \DateTime();
				if ($now < $tip->getMatch()->getStartDate()) {
					return $this->renderThenChild();
				}
			}
			*/
		}
	}
}

?>
