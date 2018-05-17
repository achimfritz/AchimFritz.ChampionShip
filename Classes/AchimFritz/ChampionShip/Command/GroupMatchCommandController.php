<?php
namespace AchimFritz\ChampionShip\Command;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use \AchimFritz\ChampionShip\Competition\Domain\Model\Cup;
use \AchimFritz\ChampionShip\Competition\Domain\Model\GroupMatch;

/**
 * GroupMatch Command Controller for the AchimFritz.ChampionShip package
 *
 * @Flow\Scope("singleton")
 */
class GroupMatchCommandController extends \TYPO3\Flow\Cli\CommandController
{

    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\GroupMatchRepository
     */
    protected $groupMatchRepository;
    
    /**
     * list
     *
     * @return void
     */
    public function listCommand()
    {
        $groupMatches = $this->groupMatchRepository->findAll();
        $this->outputLine('found ' . count($groupMatches) . ' matches');
        foreach ($groupMatches as $groupMatch) {
            $this->outputLine($groupMatch->getName());
        }
    }
}
