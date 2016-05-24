<?php
namespace AchimFritz\ChampionShip\Command;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use AchimFritz\ChampionShip\Competition\Domain\Model\Cup;
use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Competition\Domain\Model\GroupRound;

/**
 * GroupRound command controller for the AchimFritz.ChampionShip package
 *
 * @Flow\Scope("singleton")
 */
class GroupRoundCommandController extends \TYPO3\Flow\Cli\CommandController {
	
	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\GroupRoundRepository
	 */
	protected $groupRoundRepository;
	
	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\MatchRepository
	 */
	protected $matchRepository;

	/**
	 * @var \AchimFritz\ChampionShip\Competition\Domain\Service\GroupRoundService
	 * @Flow\Inject
	 */
	protected $groupRoundService;

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
	public function listCommand() {
		$groupRounds = $this->groupRoundRepository->findAll();
		#$groupRounds = array($this->groupRoundRepository->findOneByName('H'));
		if (count($groupRounds)) {
			foreach ($groupRounds AS $groupRound) {
				$this->outputLine($groupRound->getName());
				$matches = $groupRound->getGeneralMatches();
				if (count($matches)) {
					foreach ($matches as $match) {
						$line = ' ' . $match->getHostName() . ' - ' . $match->getGuestName();
						$result = $match->getResult();
						if (isset($result)) {
							$line .= ' ' . $result->getHostTeamGoals() . ':' . $result->getGuestTeamGoals();
						} else {
							$line .= ' -:-';
						}
						$this->outputLine($line);
					}
				} else {
					$this->outputLine(' no matches found');
				}
				$this->outputGroupRound($groupRound);
			}
		} else {
			$this->outputLine('no groupRounds found');
		}
	}

	/**
	 * @param string $cupName
	 * @return void
	 */
	public function finishCommand($cupName = 'em 2016') {
		$cup = $this->cupRepository->findOneByName($cupName);
		if ($cup instanceof Cup === FALSE) {
			$this->outputLine('no such cup ' . $cupName);
			$this->quit();
		}
		try {
			$groupTableRows = $this->groupRoundService->finish($cup);
			foreach ($groupTableRows AS $row) {
				$line = ' ' . $row->getRank() . '. ' . $row->getCountOfMatchesPlayed() . ' ' .  $row->getPoints();
				$line .= ' ' . $row->getGoalsDiff() . ' ' . $row->getGoalsPlus() . ':' . $row->getGoalsMinus();
				$line .= ' ' . $row->getTeam()->getName();
				$this->outputLine($line);
			}
		} catch (\AchimFritz\ChampionShip\Competition\Domain\Service\Exception $e) {
			$this->outputLine('ERROR ' . $e->getMessage() . ' - ' . $e->getCode());
		}
	}

	/**
	 * update
	 *
	 * @return void
	 */
	public function updateCommand() {
		$groupRounds = $this->groupRoundRepository->findAll();
		#$groupRounds = array($this->groupRoundRepository->findOneByName('Gruppe A'));
		foreach ($groupRounds AS $groupRound) {
				if ($groupRound->getName() != 'G' OR $groupRound->getCup()->getName() != 'wm 2002') {
					#continue;
				}
			$this->outputLine('update groupRoundTable ' . $groupRound->getCup()->getName() . ' ' . $groupRound->getName());
			$groupRound->updateGroupTable();
			$this->outputGroupRound($groupRound);
			$this->groupRoundRepository->update($groupRound);
		}
	}

	/**
	 * outputGroupRound 
	 * 
	 * @param GroupRound $groupRound 
	 * @return void
	 */
	protected function outputGroupRound(GroupRound $groupRound) {
			$groupTableRows = $groupRound->getGroupTableRows();
			if (count($groupTableRows)) {
				foreach ($groupTableRows AS $row) {
					$line = ' ' . $row->getRank() . '. ' . $row->getCountOfMatchesPlayed() . ' ' .  $row->getPoints();
					$line .= ' ' . $row->getGoalsDiff() . ' ' . $row->getGoalsPlus() . ':' . $row->getGoalsMinus();
					$line .= ' ' . $row->getTeam()->getName();
					$this->outputLine($line);
				}
			} else {
				$this->outputLine('no groupTableRows found');
			}
	}
	
	/**
	 * clean
	 *
	 * @return void
	 */
	public function cleanCommand() {
		$groupRounds = $this->groupRoundRepository->findAll();
		foreach ($groupRounds AS $groupRound) {
			$this->outputLine('clean groupRound ' . $groupRound->getName());
			$matches = $groupRound->getGeneralMatches();
			$this->outputLine('count of matches: ' . count($matches));
			foreach ($matches AS $match) {
				$this->matchRepository->remove($match);
			}
		}
	}

}

?>
