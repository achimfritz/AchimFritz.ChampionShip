<?php
namespace AchimFritz\ChampionShip\Domain\Policy;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Domain\Model\User;

/**
 * UserEditablePolicy
 *
 * @Flow\Scope("singleton")
 */
class UserEditablePolicy {

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
	 * isEditable
	 * 
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

}
?>
