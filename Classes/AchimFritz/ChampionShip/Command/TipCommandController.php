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
class TipCommandController extends \Neos\Flow\Cli\CommandController
{
    
    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\CupRepository
     */
    protected $cupRepository;
    
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
     * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\GroupMatchRepository
     */
    protected $groupMatchRepository;

    
    /**
     * listCommand
     *
     * @return void
     */
    public function listCommand()
    {
        $cup = $this->cupRepository->findOneByName('em 2008');
        #$user = $this->userRepository->findOneByUsername('af@achimfritz.de');
        $user = $this->userRepository->findOneByUsername('af@achimfritz.de');
        $tips = $this->tipRepository->findByCup($cup);
        $this->outputLine('found ' . count($tips) . ' tips in cup ' . $cup->getName());
        $tips = $this->tipRepository->findByUserInCup($user, $cup);
        $this->outputLine('found ' . count($tips) . ' tips in cup ' . $cup->getName() . ' for user ' . $user->getName());
        $rounds = $this->roundRepository->findByCup($cup);
        foreach ($rounds as $round) {
            $tips = $this->tipRepository->findByUserInRound($user, $round);
            $this->outputLine('found ' . count($tips) . ' tips in round ' . $round->getName() . ' for user ' . $user->getName());
        }
        $groupMatches = $this->groupMatchRepository->findByCup($cup);
        $tips = $this->tipRepository->findByUserInMatches($user, $groupMatches);
        $this->outputLine('found ' . count($tips) . ' tips in groupMatches');
    }
}
