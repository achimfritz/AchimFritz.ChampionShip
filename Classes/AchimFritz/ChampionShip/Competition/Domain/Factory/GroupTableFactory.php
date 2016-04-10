<?php
namespace AchimFritz\ChampionShip\Competition\Domain\Factory;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Competition\Domain\Model\GroupTableRow;
use Doctrine\Common\Collections\Collection;


/**
 * A GroupTableCalculator
 */
class GroupTableFactory {
	
	/**
	 * createTable
	 * 
	 * @param \Doctrine\Common\Collections\Collection<\AchimFritz\ChampionShip\Competition\Domain\Model\GroupMatch>
	 * @return array<GroupTableRow>
	 */
	public function createTable(Collection $matches) {
      $rows = array();
      foreach($matches AS $match) {
			$team = $match->getHostTeam();
			$teams[$team->getName()] = $team;
			$result = $match->getResult();
			if (!isset($rows[$team->getName()])) {
				$groupTableRow = new GroupTableRow();
				$groupTableRow->setTeam($team);
				$groupTableRow->setGroupRound($match->getRound());
			} else {
				$groupTableRow = $rows[$team->getName()];
			}
			if (isset($result)) {
				$groupTableRow->setPoints($groupTableRow->getPoints() + $result->getHostPoints());
				$groupTableRow->setGoalsPlus($groupTableRow->getGoalsPlus() + $result->getHostTeamGoals());
				$groupTableRow->setGoalsMinus($groupTableRow->getGoalsMinus() + $result->getGuestTeamGoals());
				$groupTableRow->setCountOfMatchesPlayed($groupTableRow->getCountOfMatchesPlayed() + 1);
				if ($result->getHostWins() === TRUE) {
					$groupTableRow->setCountOfMatchesWon($groupTableRow->getCountOfMatchesWon() + 1);
				} elseif ($result->getGuestWins() === TRUE) {
					$groupTableRow->setCountOfMatchesLoosed($groupTableRow->getCountOfMatchesLoosed() + 1);
				} else {
					$groupTableRow->setCountOfMatchesRemis($groupTableRow->getCountOfMatchesRemis() + 1);
				}
			}
			$rows[$team->getName()] = $groupTableRow;
			$team = $match->getGuestTeam();
			$teams[$team->getName()] = $team;
			if (!isset($rows[$team->getName()])) {
				$groupTableRow = new GroupTableRow();
				$groupTableRow->setTeam($team);
				$groupTableRow->setGroupRound($match->getRound());
			} else {
				$groupTableRow = $rows[$team->getName()];
			}
			if (isset($result)) {
				$groupTableRow->setPoints($groupTableRow->getPoints() + $result->getGuestPoints());
				$groupTableRow->setGoalsPlus($groupTableRow->getGoalsPlus() + $result->getGuestTeamGoals());
				$groupTableRow->setGoalsMinus($groupTableRow->getGoalsMinus() + $result->getHostTeamGoals());
				$groupTableRow->setCountOfMatchesPlayed($groupTableRow->getCountOfMatchesPlayed() + 1);
				if ($result->getGuestWins() === TRUE) {
					$groupTableRow->setCountOfMatchesWon($groupTableRow->getCountOfMatchesWon() + 1);
				} elseif ($result->getHostWins() === TRUE) {
					$groupTableRow->setCountOfMatchesLoosed($groupTableRow->getCountOfMatchesLoosed() + 1);
				} else {
					$groupTableRow->setCountOfMatchesRemis($groupTableRow->getCountOfMatchesRemis() + 1);
				}
			}
			$rows[$team->getName()] = $groupTableRow;
      }
		return $rows;
	}
}
?>
