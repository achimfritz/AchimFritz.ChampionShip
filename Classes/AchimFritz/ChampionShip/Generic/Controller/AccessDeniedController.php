<?php
namespace AchimFritz\ChampionShip\Generic\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Mvc\Controller\RestController;

/**
 * Standard controller for the AchimFritz.ChampionShip package
 *
 * @Flow\Scope("singleton")
 */
class AccessDeniedController extends AbstractActionController
{

    /**
     * Index action
     *
     * @return void
     */
    public function listAction()
    {
        $this->addErrorMessage('access denied');
        $this->response->setStatus(403);
        $this->forwardHome();
    }
}
