<?php
namespace AchimFritz\ChampionShip\Competition\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use Neos\Flow\Annotations as Flow;

use \AchimFritz\ChampionShip\Competition\Domain\Model\CrossGroupWithThirdsMatch;

/**
 * Match controller for the AchimFritz.ChampionShip package
 *
 * @Flow\Scope("singleton")
 */
class CrossGroupWithThirdsMatchController extends MatchController
{

    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\CrossGroupMatchRepository
     */
    protected $matchRepository;
        
    /**
     * @param \AchimFritz\ChampionShip\Competition\Domain\Model\CrossGroupWithThirdsMatch $match
     * @return void
     */
    public function createAction(CrossGroupWithThirdsMatch $match)
    {
        $this->createMatch($match);
        $this->redirect('index', null, null, array('match' => $match, 'cup' => $match->getCup()));
    }

    /**
     * @param \AchimFritz\ChampionShip\Competition\Domain\Model\CrossGroupWithThirdsMatch $match
     * @return void
     */
    public function deleteAction(CrossGroupWithThirdsMatch $match)
    {
        $this->deleteMatch($match);
        $this->redirect('index', 'KoRound', null, array('round' => $match->getRound(), 'cup' => $match->getCup()));
    }

    /**
     * updateAction
     *
     * @param \AchimFritz\ChampionShip\Competition\Domain\Model\CrossGroupWithThirdsMatch $match
     * @return void
     */
    public function updateAction(CrossGroupWithThirdsMatch $match)
    {
        $this->updateMatch($match);
        $this->redirect('index', null, null, array('match' => $match, 'cup' => $match->getCup()));
    }
}
