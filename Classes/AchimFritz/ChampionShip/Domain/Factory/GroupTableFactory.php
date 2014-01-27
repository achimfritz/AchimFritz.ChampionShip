<?php
namespace AchimFritz\ChampionShip\Domain\Factory;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Domain\Model\GroupTableRow;
use AchimFritz\ChampionShip\Domain\Model\Team;
use AchimFritz\ChampionShip\Domain\Model\Match;
use Doctrine\Common\Collections\Collection;


/**
 * A GroupTableCalculator
 */
class GroupTableFactory {
	
	/**
	 * createTable
	 * 
	 * @param \Doctrine\Common\Collections\Collection<\AchimFritz\ChampionShip\Domain\Model\GroupMatch>
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
			}
			$rows[$team->getName()] = $groupTableRow;
      }
		return $rows;
	}
}
?>