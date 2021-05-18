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

use Neos\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Competition\Domain\Model\Match;
use AchimFritz\ChampionShip\Competition\Domain\Model\KoMatch;
use AchimFritz\ChampionShip\Competition\Domain\Model\GroupMatch;
use AchimFritz\ChampionShip\Tip\Domain\Model\Tip;

/**
 *
 * Enter description here ...
 * @author af
 *
 */
class UserTipViewHelper extends \TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper
{

    
    /**
     * NOTE: This property has been introduced via code migration to ensure backwards-compatibility.
     * @see AbstractViewHelper::isOutputEscapingEnabled()
     * @var boolean
     */
    protected $escapeOutput = false;

    /**
     * @var \AchimFritz\ChampionShip\Tip\Domain\Repository\TipRepository
     * @Flow\Inject
     */
    protected $tipRepository;

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
     * render
     *
     * @param Match $match
     * @return string
     */
    public function render(Match $match)
    {
        $renderChildrenClosure = $this->buildRenderChildrenClosure();
        $userRole = $this->policyService->getRole('AchimFritz.ChampionShip:User');
        $account = $this->securityContext->getAccount();
        if ($account && $account->hasRole($userRole)) {
            $user = $this->userRepository->findOneByAccount($account);
            $tip = $this->tipRepository->findOneByUserAndMatch($user, $match);
            if ($tip instanceof Tip) {
                $templateVariableContainer = $this->renderingContext->getTemplateVariableContainer();
                if ($match instanceof GroupMatch) {
                    $templateVariableContainer->add('tipController', 'GroupMatchTip');
                } elseif ($match instanceof KoMatch) {
                    $templateVariableContainer->add('tipController', 'KoMatchTip');
                } else {
                    throw new \Exception('unknown match class', 1397838535);
                }
                $templateVariableContainer->add('tip', $tip);
                $output = $renderChildrenClosure();
                $templateVariableContainer->remove('tip');
                $templateVariableContainer->remove('tipController');
                return $output;
            }
        }
        $output = $renderChildrenClosure();
        return $output;
    }
}
