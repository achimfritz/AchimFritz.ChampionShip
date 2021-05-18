<?php
namespace AchimFritz\ChampionShip\Competition\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use Neos\Flow\Annotations as Flow;

use \AchimFritz\ChampionShip\Competition\Domain\Model\CrossGroupMatch;

/**
 * Match controller for the AchimFritz.ChampionShip package
 *
 * @Flow\Scope("singleton")
 */
class CrossGroupMatchController extends MatchController
{

    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\CrossGroupMatchRepository
     */
    protected $matchRepository;
        
    /**
     * @param \AchimFritz\ChampionShip\Competition\Domain\Model\CrossGroupMatch $match
     * @return void
     */
    public function createAction(CrossGroupMatch $match)
    {
        $this->createMatch($match);
        $this->redirect('index', null, null, array('match' => $match, 'cup' => $match->getCup()));
    }

    /**
     * @param \AchimFritz\ChampionShip\Competition\Domain\Model\CrossGroupMatch $match
     * @return void
     */
    public function deleteAction(CrossGroupMatch $match)
    {
        $this->deleteMatch($match);
        $this->redirect('index', 'KoRound', null, array('round' => $match->getRound(), 'cup' => $match->getCup()));
    }

    /**
     * updateAction
     *
     * @param \AchimFritz\ChampionShip\Competition\Domain\Model\CrossGroupMatch $match
     * @return void
     */
    public function updateAction(CrossGroupMatch $match)
    {
        $this->updateMatch($match);
        $this->redirect('index', null, null, array('match' => $match, 'cup' => $match->getCup()));
    }
}
