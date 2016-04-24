<?php
namespace AchimFritz\ChampionShip\Competition\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * A Round
 *
 * @Flow\Entity
 */
class GroupRound extends Round {

	/**
	 * The group table
	 * @var \Doctrine\Common\Collections\Collection<\AchimFritz\ChampionShip\Competition\Domain\Model\GroupTableRow>
	 * @ORM\OneToMany(mappedBy="groupRound", cascade={"all"})
	 * @ORM\OrderBy({"rank" = "ASC"})
	 */
	protected $groupTableRows;

	/**
	 * __construct
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
		$this->groupTableRows = new \Doctrine\Common\Collections\ArrayCollection();
	}

	/**
	 * getRoundIsFinished 
	 * 
	 * @return boolean
	 */
	public function getRoundIsFinished() {
		$matches = $this->getGeneralMatches();
		foreach ($matches AS $match) {
			if (!$match->getResult() instanceof Result) {
				return FALSE;
			}
		}
		return TRUE;
	}
	
	/**
	 * getTeamByRank
	 * 
	 * @param integer $rank
	 * @return \AchimFritz\ChampionShip\Competition\Domain\Model\Team|NULL
	 */
	public function getTeamByRank($rank) {
		$groupTableRows = $this->getGroupTableRows();
		if (isset($groupTableRows[$rank-1])) {
			$row = $groupTableRows[$rank-1];
			return $row->getTeam();
		}
		return NULL;
	}
	
	
	/**
	 * getWinnerTeam
	 * 
	 * @return \AchimFritz\ChampionShip\Competition\Domain\Model\Team
	 */
	public function getWinnerTeam() {
		return $this->getTeamByRank(1);
	}
	
	/**
	 * getSecondTeam
	 * 
	 * @return \AchimFritz\ChampionShip\Competition\Domain\Model\Team
	 */
	public function getSecondTeam() {
		return $this->getTeamByRank(2);
	}
	
	/**
	 * Get the Group table's group table rows
	 *
	 * @return \AchimFritz\ChampionShip\Competition\Domain\Model\GroupTableRow The Group table's group table rows
	 */
	public function getGroupTableRows() {
		return $this->groupTableRows;
	}

	/**
	 * Sets this Group table's group table rows
	 *
	 * @param \Doctrine\Common\Collections\Collection<\AchimFritz\ChampionShip\Competition\Domain\Model\GroupTableRow>
	 * @return void
	 */
	public function setGroupTableRows(\Doctrine\Common\Collections\Collection $groupTableRows) {
		$this->groupTableRows = $groupTableRows;
	}
	
	/**
	 * clearGroupTableRows
	 * 
	 * @return void
	 */
	public function clearGroupTableRows() {
		$this->groupTableRows->clear();
	}

	/**
	 * @return void
	 */
	public function updateGroupTable() {
		$matches = $this->getGeneralMatches();
		if (count($matches) > 0) {
			// required ?
			$this->groupTableRows->clear();
			$groupTableRows = new ArrayCollection();
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

			$cup = $this->getCup();
			$name = $cup->getGroupTablePolicy();
			$rankingPolicy = new $name;
			$rows = $rankingPolicy->updateTable($rows, $matches);
			foreach ($rows AS $row) {
				$groupTableRows->add($row);
			}
			$this->setGroupTableRows($groupTableRows);
		}
	}

	/**
	 * @return void
	 */
	public function createMatches() {
		$teams = $this->getTeams();
		if (count($teams) > 0) {
			$existingMatches = $this->getGeneralMatches();
			$teamPairs = $this->getTeamPairs($teams);

			foreach ($teamPairs AS $teamPair) {
				$matchExists = FALSE;
				if (count($existingMatches) !== 0) {
					foreach ($existingMatches AS $existingMatch) {
						if ($existingMatch->getTwoTeamsPlayThisMatch($teamPair['teamOne'], $teamPair['teamTwo'])) {
							$matchExists = TRUE;
							continue;
						}
					}
				}
				if ($matchExists === FALSE) {
					$match = new GroupMatch($this->getCup(), $this, $teamPair['teamOne'], $teamPair['teamTwo']);
					$this->addGeneralMatch($match);
				}
			}
			$this->updateGroupTable();
		}
	}

	/**
	 * getTeamPairs
	 *
	 * @param \Doctrine\Common\Collections\Collection $teams
	 * @return array
	 */
	protected function getTeamPairs(\Doctrine\Common\Collections\Collection $teams) {
		$pairs = array();
		for ($k = 0; $k < sizeof($teams); $k++) {
			for ($i = $k+1; $i < sizeof($teams); $i++) {
				$pair = array('teamOne' => $teams[$k], 'teamTwo' => $teams[$i]);
				$pairs[] = $pair;
			}
		}
		return $pairs;
	}

}

