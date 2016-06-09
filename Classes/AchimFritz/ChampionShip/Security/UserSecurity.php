<?php
namespace AchimFritz\ChampionShip\Security;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\User\Domain\Model\User;

/**
 * UserSecurity
 *
 * @Flow\Scope("singleton")
 */
class UserSecurity {

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
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\User\Domain\Repository\UserRepository
	 */
	protected $userRepository;

	/**
	 * @param User $user
	 * @return boolean
	 */
	public function editAllowed(User $user) {
		if (FLOW_SAPITYPE === 'CLI') {
			return TRUE;
		}
		if ($this->securityContext->hasRole('AchimFritz.ChampionShip:Administrator') === TRUE) {
			return TRUE;
		}
		$account = $this->securityContext->getAccount();
		if ($account === $user->getAccount()) {
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * @param User $otherOser
	 * @return bool
	 */
	public function otherUserIsVisible(User $otherUser) {
		if (FLOW_SAPITYPE === 'CLI') {
			return TRUE;
		}
		if ($this->securityContext->hasRole('AchimFritz.ChampionShip:Administrator') === TRUE) {
			return TRUE;
		}
		$account = $this->securityContext->getAccount();
		if ($account) {
			$user = $this->userRepository->findOneByAccount($account);
			if ($user->hasOneOfTipGroups($otherUser->getTipGroups()) === TRUE) {
				return TRUE;
			}
		}
		return FALSE;

	}

}

