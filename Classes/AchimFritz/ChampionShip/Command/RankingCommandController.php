<?php
namespace AchimFritz\ChampionShip\Command;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use AchimFritz\ChampionShip\Tip\Domain\Model\Tip;
use Neos\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Tip\Domain\Model\Ranking;
use AchimFritz\ChampionShip\Tip\Domain\Model\CupRanking;

/**
 * Point Command
 *
 * @Flow\Scope("singleton")
 */
class RankingCommandController extends \Neos\Flow\Cli\CommandController
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
     * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\MatchRepository
     */
    protected $matchRepository;

    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\Tip\Domain\Repository\RankingRepository
     */
    protected $rankingRepository;

    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\Tip\Domain\Repository\CupRankingRepository
     */
    protected $cupRankingRepository;

    /**
     * @Flow\Inject
     * @var \Neos\Flow\Persistence\PersistenceManagerInterface
     */
    protected $persistenceManager;

    /**
     * @var \AchimFritz\ChampionShip\Tip\Domain\Service\RankingService
     * @Flow\Inject
     */
    protected $rankingService;

    /**
     * @return void
     */
    public function updateRecentCupCommand()
    {
        $this->rankingService->updateRecentCup();
    }

    /**
     * @return void
     */
    public function updateRankingCommand()
    {
        $this->rankingService->updateRanking();
    }

    /**
     * @return void
     */
    public function updateAllCommand()
    {
        $this->rankingService->updateAll();
    }

    /**
     * @return void
     */
    public function updateCommand()
    {
        $this->rankingRepository->removeAll();
        $this->cupRankingRepository->removeAll();
        $cups = $this->cupRepository->findAll();
        $users = $this->userRepository->findAll();
        foreach ($cups as $cup) {
            $rankings = array();
            $points = array();
            $matches = $this->matchRepository->findByCup($cup);
            foreach ($users as $user) {
                $ranking = new CupRanking();
                $ranking->setUser($user);
                $ranking->setCup($cup);
                foreach ($matches as $match) {
                    $tip = $this->tipRepository->findOneByUserAndMatch($user, $match);
                    if ($tip instanceof Tip) {
                        $ranking->increaseCountOfTips();
                        $ranking->addPoints($tip->getPoints());
                    }
                }
                $rankings[] = $ranking;
                $points[] = $ranking->getPoints();
            }
            array_multisort($points, SORT_DESC, $rankings);
            $rank = 0;
            $lastPoints = 0;
            $cnt = 1;
            foreach ($rankings as $ranking) {
                if ($ranking->getPoints() > 0) {
                    if ($lastPoints !== $ranking->getPoints()) {
                        $rank = $cnt;
                    }
                    $cnt++;
                    $ranking->setRank($rank);
                    $this->cupRankingRepository->add($ranking);
                    $lastPoints = $ranking->getPoints();
                }
            }
        }
        $this->persistenceManager->persistAll();
        $rankings = array();
        $points = array();
        foreach ($users as $user) {
            $ranking = new Ranking();
            $ranking->setUser($user);
            $cupRankings = $this->cupRankingRepository->findByUser($user);
            foreach ($cupRankings as $cupRanking) {
                $ranking->addCountOfTips($cupRanking->getCountOfTips());
                $ranking->addPoints($cupRanking->getPoints());
            }
            $rankings[] = $ranking;
            $points[] = $ranking->getPoints();
        }
        array_multisort($points, SORT_DESC, $rankings);
        $rank = 1;
        $lastPoints = 0;
        $cnt = 1;
        foreach ($rankings as $ranking) {
            if ($ranking->getPoints() > 0) {
                if ($lastPoints !== $ranking->getPoints()) {
                    $rank = $cnt;
                }
                $cnt++;
                $ranking->setRank($rank);
                $this->rankingRepository->add($ranking);
                $lastPoints = $ranking->getPoints();
            }
        }
    }
}
