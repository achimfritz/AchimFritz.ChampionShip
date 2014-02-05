<?php
namespace AchimFritz\ChampionShip\Domain\Service;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

use AchimFritz\ChampionShip\Domain\Model\Ranking;
use AchimFritz\ChampionShip\Domain\Model\Cup;
use AchimFritz\ChampionShip\Domain\Model\Match;

/**
 * Team controller for the AchimFritz.ChampionShip package 
 *
 * @Flow\Scope("singleton")
 */
class RankingCalculator {

	// TODO do not use repositories in service

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\CupRepository
	 */
	protected $cupRepository;

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\TipRepository
	 */
	protected $tipRepository;

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\MatchRepository
	 */
	protected $matchRepository;

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\RankingRepository
	 */
	protected $rankingRepository;

	/**
	 * updateCup
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\Cup $cup
	 * @return array<\AchimFritz\ChampionShip\Domain\Model\Ranking> $rankings
	 */
	public function updateCup(Cup $cup) {
		$tips = $this->tipRepository->findByCup($cup);
		return $this->updateTips($tips, $cup);
	}

	/**
	 * updateMatch
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\Match $match
	 * @return array<\AchimFritz\ChampionShip\Domain\Model\Ranking> $rankings
	 */
	public function updateMatch(Match $match) {
		$tips = $this->tipRepository->findByGeneralMatch($match);
		return $this->updateTips($tips, $match->getCup());
	}

	/**
	 * updateTips
	 *
	 * @param \Iterator $tips
	 * @param \AchimFritz\ChampionShip\Domain\Model\Cup $cup
	 * @return array<\AchimFritz\ChampionShip\Domain\Model\Ranking> $rankings
	 */
	protected function updateTips(\Iterator $tips, Cup $cup) {
      $userRankings = array();
      foreach ($tips AS $tip) {
         $user = $tip->getUser();
         $identifier = $user->getAccount()->getAccountIdentifier();
         if (!isset($userRankings[$identifier])) {
            $ranking = $this->rankingRepository->findOneByUserInCup($user, $cup);
            if (!$ranking instanceof Ranking) {
               $ranking = new Ranking();
               $ranking->setCup($cup);
               $ranking->setUser($user);
               $this->rankingRepository->add($ranking);
            }
            $ranking->setPoints(0);
         } else {
            $ranking = $userRankings[$identifier];
         }
         $points = $tip->getPoints();
         $ranking->setPoints($ranking->getPoints() + $points);
         $userRankings[$identifier] = $ranking;
      }
		foreach ($userRankings AS $ranking) {
			$this->rankingRepository->update($ranking);
		}
		return $userRankings;
	}


}

?>
