<?php
namespace AchimFritz\ChampionShip\Tip\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use Neos\Flow\Annotations as Flow;

/**
 * Standard controller for the AchimFritz.ChampionShip package
 *
 * @Flow\Scope("singleton")
 */
class OtherTipController extends AbstractTipGroupController
{


    /**
     * @return void
     */
    public function listAction()
    {
        $this->view->assign('cupId', $this->persistenceManager->getIdentifierByObject($this->cup));
    }
}
