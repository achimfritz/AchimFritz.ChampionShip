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

use AchimFritz\ChampionShip\User\Domain\Model\User;
use Neos\Flow\Annotations as Flow;

/**
 *
 * Enter description here ...
 * @author af
 *
 */
class UserNameViewHelper extends \Neos\FluidAdaptor\Core\ViewHelper\AbstractViewHelper
{

    
    /**
     * NOTE: This property has been introduced via code migration to ensure backwards-compatibility.
     * @see AbstractViewHelper::isOutputEscapingEnabled()
     * @var boolean
     */
    protected $escapeOutput = false;

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
     * @return string
     */
    public function render()
    {
        $account = $this->securityContext->getAccount();
        if ($account) {
            $user = $this->userRepository->findOneByAccount($account);
            if ($user instanceof User) {
                return $user->getDisplayName();
            } else {
                return 'ADMIN';
            }
        } else {
            return '';
        }
    }
}
