<?php
namespace AchimFritz\ChampionShip\Competition\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use Neos\Flow\Annotations as Flow;

use \AchimFritz\ChampionShip\Competition\Domain\Model\KoRound;

/**
 * KoRound controller for the AchimFritz.ChampionShip package
 *
 * @Flow\Scope("singleton")
 */
class KoRoundController extends RoundController
{

    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\KoRoundRepository
     */
    protected $roundRepository;
    
    /**
     * createAction
     *
     * @param \AchimFritz\ChampionShip\Competition\Domain\Model\KoRound $round
     * @return void
     */
    public function createAction(KoRound $round)
    {
        $this->createRound($round);
        $this->redirect('index', null, null, array('cup' => $round->getCup(), 'round' => $round));
    }

    /**
     * updateAction
     *
     * @param \AchimFritz\ChampionShip\Competition\Domain\Model\KoRound $round
     * @return void
     */
    public function updateAction(KoRound $round)
    {
        $this->updateRound($round);
        $this->redirect('index', null, null, array('cup' => $round->getCup(), 'round' => $round));
    }

    /**
     * deleteAction
     *
     * @param \AchimFritz\ChampionShip\Competition\Domain\Model\KoRound $round
     * @return void
     */
    public function deleteAction(KoRound $round)
    {
        $this->deleteRound($round);
        $this->redirect('index', null, null, array('cup' => $round->getCup()));
    }
}
