<?php
namespace AchimFritz\ChampionShip\Command;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use Neos\Flow\Annotations as Flow;
use \AchimFritz\ChampionShip\Competition\Domain\Model\KoMatch;
use \AchimFritz\ChampionShip\Competition\Domain\Model\Result;
use \AchimFritz\ChampionShip\Competition\Domain\Model\TeamsOfTwoMatchesMatch;

/**
 * Point Command
 *
 * @Flow\Scope("singleton")
 */
class RandomGroupResultsCommandController extends \Neos\Flow\Cli\CommandController
{

    /**
     * @Flow\Inject
     * @var \Neos\Flow\Persistence\PersistenceManagerInterface
     */
    protected $persistenceManager;

    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\CupRepository
     */
    protected $cupRepository;
    
    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\GroupMatchRepository
     */
    protected $matchRepository;

    protected $results = [
        [1, 1],
        [0, 0],
        [1, 1],
        [0, 0],
        [1, 0],
        [2, 0],
        [3, 1],
        [4, 0],
        [2, 2],
        [2, 2],
        [2, 1],
        [0, 1],
        [0, 2],
        [1, 3],
        [0, 4],
        [1, 2]
    ];


    public function createCommand(string $cupName = 'em 2021'): int
    {
        $cup = $this->cupRepository->findOneByName($cupName);
        if ($cup === null) {
            $this->outputLine('no such cup: ' . $cupName);
            return 1;
        }
        $matches = $this->matchRepository->findByCup($cup);
        foreach($matches as $match) {
            $res = rand(0, count($this->results) - 1);
            $result = new Result($this->results[$res][0], $this->results[$res][1]);
            $match->setResult($result);
            $this->matchRepository->update($match);
            $this->persistenceManager->persistAll();
            $this->outputLine($match->getName());
        }
        return 0;
    }

}
