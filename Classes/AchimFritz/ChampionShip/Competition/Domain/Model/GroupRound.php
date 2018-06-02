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
class GroupRound extends Round
{

    /**
     * The group table
     * @var \Doctrine\Common\Collections\Collection<\AchimFritz\ChampionShip\Competition\Domain\Model\GroupTableRow>
     * @ORM\OneToMany(mappedBy="groupRound", cascade={"all"})
     * @ORM\OrderBy({"rank" = "ASC"})
     */
    protected $groupTableRows;

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->groupTableRows = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return boolean
     */
    public function getRoundIsFinished()
    {
        $matches = $this->getGeneralMatches();
        foreach ($matches as $match) {
            if (!$match->getResult() instanceof Result) {
                return false;
            }
        }
        return true;
    }
    
    /**
     * @param integer $rank
     * @return \AchimFritz\ChampionShip\Competition\Domain\Model\Team|NULL
     */
    public function getTeamByRank($rank)
    {
        $row = $this->getGroupTableRowByRank($rank);
        if ($row !== null) {
            return $row->getTeam();
        }
        return null;
    }

    /**
     * @param integer $rank
     * @return \AchimFritz\ChampionShip\Competition\Domain\Model\GroupTableRow|NULL
     */
    public function getGroupTableRowByRank($rank)
    {
        $groupTableRows = $this->getGroupTableRows();
        if (isset($groupTableRows[$rank-1])) {
            return $groupTableRows[$rank-1];
        }
        return null;
    }
    
    
    /**
     * @return \AchimFritz\ChampionShip\Competition\Domain\Model\Team
     */
    public function getWinnerTeam()
    {
        return $this->getTeamByRank(1);
    }
    
    /**
     * @return \AchimFritz\ChampionShip\Competition\Domain\Model\Team
     */
    public function getSecondTeam()
    {
        return $this->getTeamByRank(2);
    }

    /**
     * @return \AchimFritz\ChampionShip\Competition\Domain\Model\Team
     */
    public function getThirdTeam()
    {
        return $this->getTeamByRank(3);
    }
    
    /**
     * @return \AchimFritz\ChampionShip\Competition\Domain\Model\GroupTableRow The Group table's group table rows
     */
    public function getGroupTableRows()
    {
        return $this->groupTableRows;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection<\AchimFritz\ChampionShip\Competition\Domain\Model\GroupTableRow>
     * @return void
     */
    public function setGroupTableRows(\Doctrine\Common\Collections\Collection $groupTableRows)
    {
        $this->groupTableRows = $groupTableRows;
    }
    
    /**
     * @return void
     */
    public function clearGroupTableRows()
    {
        $this->groupTableRows->clear();
    }

    /**
     * @return void
     */
    public function updateGroupTable()
    {
        $matches = $this->getGeneralMatches();
        if (count($matches) > 0) {
            // required ?
            $this->groupTableRows->clear();
            $groupTableRows = new ArrayCollection();
            foreach ($matches as $match) {
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
                    if ($result->getHostWins() === true) {
                        $groupTableRow->setCountOfMatchesWon($groupTableRow->getCountOfMatchesWon() + 1);
                    } elseif ($result->getGuestWins() === true) {
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
                    if ($result->getGuestWins() === true) {
                        $groupTableRow->setCountOfMatchesWon($groupTableRow->getCountOfMatchesWon() + 1);
                    } elseif ($result->getHostWins() === true) {
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
            if ($this->getRoundIsFinished() === true) {
                $rows = $rankingPolicy->updateTable($rows, $matches);
            }
            foreach ($rows as $row) {
                $groupTableRows->add($row);
            }
            $this->setGroupTableRows($groupTableRows);
        }
    }

    /**
     * @return void
     */
    public function createMatches()
    {
        $teams = $this->getTeams();
        if (count($teams) > 0) {
            $existingMatches = $this->getGeneralMatches();
            $teamPairs = $this->getTeamPairs($teams);

            foreach ($teamPairs as $teamPair) {
                $matchExists = false;
                if (count($existingMatches) !== 0) {
                    foreach ($existingMatches as $existingMatch) {
                        if ($existingMatch->getTwoTeamsPlayThisMatch($teamPair['teamOne'], $teamPair['teamTwo'])) {
                            $matchExists = true;
                            continue;
                        }
                    }
                }
                if ($matchExists === false) {
                    $match = new GroupMatch($this->getCup(), $this, $teamPair['teamOne'], $teamPair['teamTwo']);
                    $this->addGeneralMatch($match);
                }
            }
            $this->updateGroupTable();
        }
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $teams
     * @return array
     */
    protected function getTeamPairs(\Doctrine\Common\Collections\Collection $teams)
    {
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
