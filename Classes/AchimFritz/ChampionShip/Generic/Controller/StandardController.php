<?php
namespace AchimFritz\ChampionShip\Generic\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

/**
 * Standard controller for the AchimFritz.ChampionShip package
 *
 * @Flow\Scope("singleton")
 */
class StandardController extends AbstractActionController
{


    /**
     * @return void
     */
    public function listAction()
    {
        $this->redirect('index', 'Cup', 'AchimFritz.ChampionShip\\Competition');
    }
}
