<?php
namespace AchimFritz\ChampionShip\Tip\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

/**
 * Match controller for the AchimFritz.ChampionShip package
 *
 * @Flow\Scope("singleton")
 */
class GroupMatchTipController extends AbstractActionController
{
        
    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\GroupMatchRepository
     */
    protected $matchRepository;

    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\Tip\Domain\Repository\TipRepository
     */
    protected $tipRepository;
    
    /**
     * listAction
     *
     * @return void
     */
    public function listAction()
    {
        $matches = $this->matchRepository->findByCup($this->cup);
        $tips = $this->tipRepository->findByUserInMatches($this->user, $matches);
        $this->view->assign('tips', $tips);
    }
}
