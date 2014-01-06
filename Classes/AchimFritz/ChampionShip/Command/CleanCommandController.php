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
class CleanCommandController extends \TYPO3\Flow\Cli\CommandController {
	
	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\TeamRepository
	 */
	protected $teamRepository;

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\CupRepository
	 */
	protected $cupRepository;
	
	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\RankingRepository
	 */
	protected $rankingRepository;
	
	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\TipGroupRepository
	 */
	protected $tipGroupRepository;
	
	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\TipRepository
	 */
	protected $tipRepository;
	
	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\UserRepository
	 */
	protected $userRepository;

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\RoundRepository
	 */
	protected $roundRepository;
	
	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\MatchRepository
	 */
	protected $matchRepository;

	/**
	 * deleteTeamsCommand
	 * 
	 * @return void
	 */
	public function deleteTeamsCommand() {
		$teams = $this->teamRepository->findAll();
		$this->outputLine('count: ' . count($teams));
		foreach ($teams AS $team) {
			$this->teamRepository->remove($team);
		}
	}

	/**
	 * deleteCupsCommand
	 * 
	 * @return void
	 */
	public function deleteCupsCommand() {
		$cups = $this->cupRepository->findAll();
		$this->outputLine('count: ' . count($cups));
		foreach ($cups AS $cup) {
			$this->cupRepository->remove($cup);
		}
	}
	/**
	 * deleteUsersCommand
	 * 
	 * @return void
	 */
	public function deleteUsersCommand() {
		$users = $this->userRepository->findAll();
		$this->outputLine('found ' . count($users));
		foreach ($users AS $user) {
			$this->userRepository->remove($user);
		}
	}
}

?>
