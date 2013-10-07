<?php
namespace AchimFritz\ChampionShip\Command;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use \AchimFritz\ChampionShip\Domain\Model\Cup;
use \AchimFritz\ChampionShip\Domain\Model\Ranking;

/**
 * Point Command
 *
 * @Flow\Scope("singleton")
 */
class RankingCommandController extends \TYPO3\Flow\Cli\CommandController {
	
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
	 * @var \AchimFritz\ChampionShip\Domain\Repository\RankingRepository
	 */
	protected $rankingRepository;
	
	/**
	 * updateCommand 
	 * 
	 * @param string $cupName 
	 * @return void
	 */
	public function updateCommand($cupName) {
		$cup = $this->cupRepository->findOneByName($cupName);
		if (!$cup instanceof Cup) {
			$this->outputLine('no cup found with name ' . $cupName);
			$this->quit();
		}
		$tips = $this->tipRepository->findByCup($cup);
		$this->outputLine('found ' . count($tips) . ' tips in cup ' . $cup->getName());
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
			$this->outputLine($ranking->getUser()->getName() . ' ' . $ranking->getPoints());
		}
	}
}

?>
