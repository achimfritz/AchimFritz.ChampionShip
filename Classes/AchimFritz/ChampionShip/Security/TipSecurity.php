<?php
namespace AchimFritz\ChampionShip\Security;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Tip\Domain\Model\Tip;

/**
 * TipSecurity
 *
 * @Flow\Scope("singleton")
 */
class TipSecurity {

	/**
	 * @var \TYPO3\Flow\Security\Context
	 * @Flow\Inject
	 */
	protected $securityContext;

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\User\Domain\Repository\UserRepository
	 */
	protected $userRepository;

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\Security\Policy\PolicyService
	 */
	protected $policyService;

	/**
	 * isEditable
	 * 
	 * @param Tip $tip 
	 * @return boolean
	 */
	public function editAllowed(Tip $tip) {
		if (FLOW_SAPITYPE === 'CLI') {
			return TRUE;
		}
		if ($this->securityContext->hasRole('AchimFritz.ChampionShip:Administrator') === TRUE) {
			return TRUE;
		}
		$account = $this->securityContext->getAccount();
		if ($account) {
			$user = $this->userRepository->findOneByAccount($account);
			if ($user === $tip->getUser()) {
				$now = new \DateTime();
				if ($now < $tip->getMatch()->getStartDate()) {
					return TRUE;
				}
			}
		}
		return FALSE;
	}

}
?>
