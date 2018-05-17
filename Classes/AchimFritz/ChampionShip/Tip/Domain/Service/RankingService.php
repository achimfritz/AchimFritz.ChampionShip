<?php
namespace AchimFritz\ChampionShip\Tip\Domain\Service;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */
use AchimFritz\ChampionShip\Competition\Domain\Model\Cup;
use AchimFritz\ChampionShip\Tip\Domain\Model\CupRanking;
use AchimFritz\ChampionShip\Tip\Domain\Model\Tip;
use AchimFritz\ChampionShip\Tip\Domain\Model\Ranking;
use TYPO3\Flow\Annotations as Flow;

/**
 * @Flow\Scope("singleton")
 */
class RankingService
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
     * @var \TYPO3\Flow\Persistence\PersistenceManagerInterface
     */
    protected $persistenceManager;

    /**
     * @param Cup $cup
     * @return void
     * @throws \TYPO3\Flow\Persistence\Exception\IllegalObjectTypeException
     */
    public function updateCupRanking(Cup $cup)
    {
        $cupRankings = $this->cupRankingRepository->findByCup($cup);
        foreach ($cupRankings as $cupRanking) {
            $this->cupRankingRepository->remove($cupRanking);
        }
        $users = $this->userRepository->findAll();
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
        $this->persistenceManager->persistAll();
    }

    /**
     * @return void
     * @throws \TYPO3\Flow\Persistence\Exception\IllegalObjectTypeException
     */
    public function updateRanking()
    {
        $this->rankingRepository->removeAll();
        $users = $this->userRepository->findAll();
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
        $this->persistenceManager->persistAll();
    }

    /**
     * @return void
     */
    public function updateRecentCup()
    {
        $cup = $this->cupRepository->findOneRecent();
        $this->updateCupRanking($cup);
    }

    /**
     * @return void
     */
    public function updateAll()
    {
        $cups = $this->cupRepository->findAll();
        foreach ($cups as $cup) {
            $this->updateCupRanking($cup);
        }
        $this->updateRanking();
    }
}
