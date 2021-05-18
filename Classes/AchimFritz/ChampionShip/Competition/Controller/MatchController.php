<?php
namespace AchimFritz\ChampionShip\Competition\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use Neos\Flow\Annotations as Flow;

use \AchimFritz\ChampionShip\Competition\Domain\Model\Match;
use \AchimFritz\ChampionShip\Competition\Domain\Model\Cup;

/**
 * Match controller for the AchimFritz.ChampionShip package
 *
 * @Flow\Scope("singleton")
 */
class MatchController extends AbstractActionController
{
        
    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\MatchRepository
     */
    protected $matchRepository;

    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\KoRoundRepository
     */
    protected $koRoundRepository;

    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\GroupRoundRepository
     */
    protected $groupRoundRepository;

    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\TeamRepository
     */
    protected $teamRepository;

    /**
     * @var string
     */
    protected $resourceArgumentName = 'match';

    /**
     * @var array
     */
    protected $viewFormatToObjectNameMap = array('json' => 'AchimFritz\\ChampionShip\\Mvc\\View\\MatchesJsonView');
    
    /**
     * listAction
     *
     * @param \AchimFritz\ChampionShip\Competition\Domain\Model\Cup $cup
     */
    public function listAction(Cup $cup)
    {
        $matches = $this->matchRepository->findByCup($cup);
        if (count($matches) === 0) {
            $this->addErrorMessage('no matches found, create a useable GroupRound');
            $this->redirect('index', 'GroupRound');
        }
        $this->view->assign('matches', $matches);
        #$this->view->assign('allTeams', $this->teamRepository->findAll());
        #$this->view->assign('allGroupRounds', $this->groupRoundRepository->findByCup($cup));
        #$this->view->assign('allKoRounds', $this->koRoundRepository->findByCup($cup));
        #$this->view->assign('recentCup', $cup);
    }

    /**
     * showAction
     *
     * @param \AchimFritz\ChampionShip\Competition\Domain\Model\Match $match
     */
    public function showAction(Match $match)
    {
        $this->view->assign('match', $match);
        $cup = $match->getCup();
        $this->view->assign('allTeams', $this->teamRepository->findAll());
        $this->view->assign('allGroupRounds', $this->groupRoundRepository->findByCup($cup));
        $this->view->assign('allKoRounds', $this->koRoundRepository->findByCup($cup));
        $this->view->assign('recentCup', $match->getCup());
    }

    /**
     * @param \AchimFritz\ChampionShip\Competition\Domain\Model\Match $match The match to update
     * @return void
     */
    protected function updateMatch(Match $match)
    {
        try {
            $this->matchRepository->update($match);
            $this->addOkMessage('match updated');
        } catch (\Exception $e) {
            $this->addErrorMessage('cannot update match');
            $this->handleException($e);
        }
    }

    /**
     * @param \AchimFritz\ChampionShip\Competition\Domain\Model\Match $match The match to update
     * @return void
     */
    protected function deleteMatch(Match $match)
    {
        try {
            $this->matchRepository->remove($match);
            $this->addOkMessage('match deleted');
        } catch (\Exception $e) {
            $this->addErrorMessage('cannot delete match');
            $this->handleException($e);
        }
    }

    /**
     * @param \AchimFritz\ChampionShip\Competition\Domain\Model\Match $match
     * @return void
     */
    protected function createMatch(Match $match)
    {
        try {
            $this->matchRepository->add($match);
            $this->addOkMessage('match created');
        } catch (\Exception $e) {
            $this->addErrorMessage('cannot create match');
            $this->handleException($e);
        }
    }
}
