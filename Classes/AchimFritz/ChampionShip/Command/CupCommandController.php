<?php
namespace AchimFritz\ChampionShip\Command;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use Neos\Flow\Annotations as Flow;

/**
 * Cup Command Controller for the AchimFritz.ChampionShip package
 *
 * @Flow\Scope("singleton")
 */
class CupCommandController extends \Neos\Flow\Cli\CommandController
{
    
    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\CupRepository
     */
    protected $cupRepository;
    
    /**
     * list
     *
     * @return void
     */
    public function listCommand()
    {
        $cups = $this->cupRepository->findAll();
        foreach ($cups as $cup) {
            $this->outputLine($cup->getName());
        }
    }
}
