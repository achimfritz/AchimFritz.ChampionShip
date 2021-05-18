<?php
namespace AchimFritz\ChampionShip\Security;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use Neos\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\User\Domain\Model\User;

/**
 * UserSecurity
 *
 * @Flow\Scope("singleton")
 */
class UserSecurity
{

    /**
     * @var \Neos\Flow\Security\Context
     * @Flow\Inject
     */
    protected $securityContext;

    /**
     * @Flow\Inject
     * @var \Neos\Flow\Security\Policy\PolicyService
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
    public function editAllowed(User $user)
    {
        if (FLOW_SAPITYPE === 'CLI') {
            return true;
        }
        if ($this->securityContext->hasRole('AchimFritz.ChampionShip:Administrator') === true) {
            return true;
        }
        $account = $this->securityContext->getAccount();
        if ($account === $user->getAccount()) {
            return true;
        }
        return false;
    }

    /**
     * @param User $otherOser
     * @return bool
     */
    public function otherUserIsVisible(User $otherUser)
    {
        if (FLOW_SAPITYPE === 'CLI') {
            return true;
        }
        if ($this->securityContext->hasRole('AchimFritz.ChampionShip:Administrator') === true) {
            return true;
        }
        $account = $this->securityContext->getAccount();
        if ($account) {
            $user = $this->userRepository->findOneByAccount($account);
            if ($user->hasOneOfTipGroups($otherUser->getTipGroups()) === true) {
                return true;
            }
        }
        return false;
    }
}
