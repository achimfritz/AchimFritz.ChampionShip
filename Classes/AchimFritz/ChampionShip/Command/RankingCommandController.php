<?php
namespace AchimFritz\ChampionShip\Command;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use AchimFritz\ChampionShip\Tip\Domain\Model\Tip;
use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Tip\Domain\Model\Ranking;
use AchimFritz\ChampionShip\Tip\Domain\Model\CupRanking;

/**
 * Point Command
 *
 * @Flow\Scope("singleton")
 */
class RankingCommandController extends \TYPO3\Flow\Cli\CommandController {
	
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
	 * listCommand
	 * 
	 * @return void
	 */
	public function updateCommand() {
		$this->rankingRepository->removeAll();
		$this->cupRankingRepository->removeAll();
		$cups = $this->cupRepository->findAll();
		#$cups = array($this->cupRepository->findOneByName('wm 2014'));
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
					#$this->outputLine($rank . ':' . $ranking->getUser()->getDisplayName() . ' ' . $ranking->getPoints() . ' - ' . $lastPoints);
					$ranking->setRank($rank);
					$this->cupRankingRepository->add($ranking);
					$lastPoints = $ranking->getPoints();
				}
			}
		}
		#$this->quit();
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
				#$this->outputLine($rank . ':' . $ranking->getUser()->getDisplayName() . ' ' . $ranking->getPoints() . ' - ' . $lastPoints);
				$ranking->setRank($rank);
				$this->rankingRepository->add($ranking);
				$lastPoints = $ranking->getPoints();
			}
			/*
			$ranking->setRank($rank);
			if ($ranking->getPoints() > 0) {
				$this->rankingRepository->add($ranking);
				if ($lastPoints !== $ranking->getPoints()) {
					$rank ++;
				}
			}
			$lastPoints = $ranking->getPoints();
			*/
		}
	}
}
