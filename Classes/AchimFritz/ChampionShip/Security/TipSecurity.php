<?php
namespace AchimFritz\ChampionShip\Security;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use Neos\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Tip\Domain\Model\Tip;

/**
 * TipSecurity
 *
 * @Flow\Scope("singleton")
 */
class TipSecurity
{

    /**
     * @var \Neos\Flow\Security\Context
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
     * @var \Neos\Flow\Security\Policy\PolicyService
     */
    protected $policyService;

    /**
     * isEditable
     *
     * @param Tip $tip
     * @return boolean
     */
    public function editAllowed(Tip $tip)
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
            if ($user === $tip->getUser()) {
                $now = new \DateTime();
                if ($now < $tip->getMatch()->getStartDate()) {
                    return true;
                }
            }
        }
        return false;
    }
}
