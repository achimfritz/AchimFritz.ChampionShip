<?php
namespace AchimFritz\ChampionShip\Command;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use Neos\Flow\Annotations as Flow;
use \AchimFritz\ChampionShip\Competition\Domain\Model\Cup;
use \AchimFritz\ChampionShip\Competition\Domain\Model\GroupMatch;

/**
 * GroupMatch Command Controller for the AchimFritz.ChampionShip package
 *
 * @Flow\Scope("singleton")
 */
class TeamCommandController extends \Neos\Flow\Cli\CommandController
{

    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\TeamRepository
     */
    protected $teamRepository;
    
    /**
     * list
     *
     * @return void
     */
    public function listCommand()
    {
        $teams = $this->teamRepository->findAll();
        $this->outputLine('found ' . count($teams->toArray()) . ' teams');
        foreach ($teams as $team) {
            $this->outputLine($team->getName());
        }
    }
}
