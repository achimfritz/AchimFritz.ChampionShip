<?php
namespace AchimFritz\ChampionShip\Command;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use Neos\Flow\Annotations as Flow;
use \AchimFritz\ChampionShip\Competition\Domain\Model\Cup;
use \AchimFritz\ChampionShip\Tip\Domain\Model\Ranking;

/**
 * Point Command
 *
 * @Flow\Scope("singleton")
 */
class CleanCommandController extends \Neos\Flow\Cli\CommandController
{
    
    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\TeamRepository
     */
    protected $teamRepository;

    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\CupRepository
     */
    protected $cupRepository;
    
    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\User\Domain\Repository\TipGroupRepository
     */
    protected $tipGroupRepository;
    
    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\Tip\Domain\Repository\TipRepository
     */
    protected $tipRepository;
    
    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\User\Domain\Repository\UserRepository
     */
    protected $userRepository;

    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\RoundRepository
     */
    protected $roundRepository;
    
    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\MatchRepository
     */
    protected $matchRepository;

    /**
     * deleteTeamsCommand
     *
     * @return void
     */
    public function deleteTeamsCommand()
    {
        $teams = $this->teamRepository->findAll();
        $this->outputLine('count: ' . count($teams));
        foreach ($teams as $team) {
            $this->teamRepository->remove($team);
        }
    }

    /**
     * deleteCupsCommand
     *
     * @return void
     */
    public function deleteCupsCommand()
    {
        $cups = $this->cupRepository->findAll();
        $this->outputLine('count: ' . count($cups));
        foreach ($cups as $cup) {
            $this->cupRepository->remove($cup);
        }
    }
    /**
     * deleteUsersCommand
     *
     * @return void
     */
    public function deleteUsersCommand()
    {
        $users = $this->userRepository->findAll();
        $this->outputLine('found ' . count($users));
        foreach ($users as $user) {
            $this->userRepository->remove($user);
        }
    }
}
