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
class EnvironmentViewHelper extends \TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper {

	
	/**
	 * NOTE: This property has been introduced via code migration to ensure backwards-compatibility.
	 * @see AbstractViewHelper::isOutputEscapingEnabled()
	 * @var boolean
	 */
	protected $escapeOutput = FALSE;

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\CupRepository
	 */
	protected $cupRepository;

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\User\Domain\Repository\UserRepository
	 */
	protected $userRepository;

	/**
	 * @var \TYPO3\Flow\Security\Context
	 * @Flow\Inject
	 */
	protected $securityContext;

	/**
	 * @return void
	 */
	public function render() {
		$request = $this->controllerContext->getRequest();
		if ($request->hasArgument('cup')) {
			$arg = $request->getArgument('cup');
			if (isset($arg['__identity'])) {
				$cup = $this->cupRepository->findByIdentifier($arg['__identity']);
			}
		} else {
			$cup = $this->cupRepository->findOneRecent();
		}
		$cups = $this->cupRepository->findAll();

		if ($this->templateVariableContainer->exists('user') === FALSE) {
			$account = $this->securityContext->getAccount();
			if ($account) {
				$user = $this->userRepository->findOneByAccount($account);
				$this->templateVariableContainer->add('user', $user);
			}
		}

		if ($this->templateVariableContainer->exists('cup') === FALSE) {
			$this->templateVariableContainer->add('cup', $cup);
		}
		if ($this->templateVariableContainer->exists('cups') === FALSE) {
			$this->templateVariableContainer->add('cups', $cups);
		}
		$out = $this->renderChildren();
		return $out;
	}
}

