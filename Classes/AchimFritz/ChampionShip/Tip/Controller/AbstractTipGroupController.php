<?php
namespace AchimFritz\ChampionShip\Tip\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use Neos\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\User\Domain\Model\User;

class AbstractTipGroupController extends AbstractActionController
{

    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\User\Domain\Repository\TipGroupRepository
     */
    protected $tipGroupRepository;

    /**
     * initializeView
     *
     * @return void
     */
    protected function initializeView(\Neos\Flow\Mvc\View\ViewInterface $view)
    {
        parent::initializeView($view);
        if ($this->user instanceof User) {
            $this->view->assign('tipGroups', $this->user->getTipGroups());
        } else {
            // admin only
            $this->view->assign('tipGroups', $this->tipGroupRepository->findAll());
        }
    }
}
