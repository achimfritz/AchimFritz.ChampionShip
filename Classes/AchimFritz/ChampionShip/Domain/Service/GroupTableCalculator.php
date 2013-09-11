<?php
namespace AchimFritz\ChampionShip\Domain\Service;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Domain\Model\GroupTableRow;


/**
 * A GroupTableCalculator
 */
class GroupTableCalculator {
	
	/**
	 * updateGroup
	 * 
	 * @param \Doctrine\Common\Collections\Collection<\AchimFritz\ChampionShip\Domain\Model\Match>
	 * @return \Doctrine\Common\Collections\Collection<\AchimFritz\ChampionShip\Domain\Model\GroupTableRows>
	 */
	public function getGroupTableRows(\Doctrine\Common\Collections\Collection $matches) {
      $groupTableRows = new \Doctrine\Common\Collections\ArrayCollection();
      $rows = array();
      foreach($matches AS $match) {
            // TODO this must exist
         $team = $match->getHostTeam();
         $result = $match->getResult();
         if (isset($result)) {
            if (!isset($rows[$team->getName()])) {
               $groupTableRow = new GroupTableRow();
               $groupTableRow->setTeam($team);
               $groupTableRow->setGroupRound($match->getRound());
            } else {
               $groupTableRow = $rows[$team->getName()];
            }
            $groupTableRow->setPoints($groupTableRow->getPoints() + $result->getHostPoints());
            $groupTableRow->setGoalsPlus($groupTableRow->getGoalsPlus() + $result->getHostTeamGoals());
            $groupTableRow->setGoalsMinus($groupTableRow->getGoalsMinus() + $result->getGuestTeamGoals());
            $groupTableRow->setCountOfMatchesPlayed($groupTableRow->getCountOfMatchesPlayed() + 1);
            $rows[$team->getName()] = $groupTableRow;
         }
         $team = $match->getGuestTeam();
         if (isset($result)) {
            // same sam
            if (!isset($rows[$team->getName()])) {
               $groupTableRow = new GroupTableRow();
               $groupTableRow->setTeam($team);
               $groupTableRow->setGroupRound($match->getRound());
            } else {
               $groupTableRow = $rows[$team->getName()];
            }
            $groupTableRow->setPoints($groupTableRow->getPoints() + $result->getGuestPoints());
            $groupTableRow->setGoalsPlus($groupTableRow->getGoalsPlus() + $result->getGuestTeamGoals());
            $groupTableRow->setGoalsMinus($groupTableRow->getGoalsMinus() + $result->getHostTeamGoals());
            $groupTableRow->setCountOfMatchesPlayed($groupTableRow->getCountOfMatchesPlayed() + 1);
            $rows[$team->getName()] = $groupTableRow;
         }
            
      }
      $rows = $this->setRank($rows);
      $rows = $this->checkDirect($rows, $matches);
      foreach ($rows AS $row) {
         $groupTableRows->add($row);
      }
      return $groupTableRows;
	}


   /**
    * checkDirect 
    * 
    * @param array $rows 
    * @param \Doctrine\Common\Collections\Collection $matches
    * @return array
    */
   protected function checkDirect(array $rows, \Doctrine\Common\Collections\Collection $matches) {
      $res = array();
      foreach ($rows AS $row) {
         $res[] = $row;
      }
      for ($i = 0; $i < sizeof($res) - 1; $i++) {
         $row = $res[$i];
         $next = $res[$i+1];
         if ($this->rowsAreEqual($row, $next)) {
               // compare this teams match
            $this->checkDirectTwo($matches, $row, $next);
            $res[$i] = $row;
            $res[$i+1] = $next;
            if ($i + 2 < sizeof($res)) {
               $overNext = $res[$i+2];
               if ($this->rowsAreEqual($next, $overNext)) {
                  // compare 3 team table
               }
            }
         }
      }
      return $res;
   }

   /**
    * checkDirectTwo 
    * 
    * @param \Doctrine\Common\Collections\Collection $matches 
    * @param GroupTableRow $row 
    * @param GroupTableRow $next 
    * @return void
    */
   protected function checkDirectTwo(\Doctrine\Common\Collections\Collection $matches, GroupTableRow $row, GroupTableRow $next) {
      $teamOne = $row->getTeam();
      $teamTwo = $next->getTeam();
      foreach ($matches AS $match) {
         if ($match->getTwoTeamsPlayThisMatch($teamOne, $teamTwo)) {
            if ($row->getRank() < $next->getRank() AND $match->getTeamHasWonThisMatch($teamTwo)) {
               var_dump($row->getTeam()->getName() . ' ' . $row->getRank());
               $rank = $row->getRank();
               $row->setRank($next->getRank());
               $next->setRank($rank);
            }
         }
      }
   }

   /**
    * rowsAreEquay 
    * 
    * @param GroupTableRow $rowOne 
    * @param GroupTableRow $rowTwo 
    * @return boolean
    */
   protected function rowsAreEqual(GroupTableRow $rowOne, GroupTableRow $rowTwo) {
      if ($rowOne->getPoints() === $rowTwo->getPoints()
         AND $rowOne->getGoalsDiff() === $rowTwo->getGoalsDiff()
         AND $rowOne->getGoalsPlus() === $rowTwo->getGoalsPlus()) {
         return TRUE;
      } else {
         return FALSE;
      }
   }

   /**
    * setRank 
    * 
    * @param array
    * @return array
    */
   protected function setRank(array $rows) {
      $points = array();
      $goalsDiff = array();
      $goalsPlus = array();
      foreach ($rows AS $row) {
         $points[] = $row->getPoints();
         $goalsDiff[] = $row->getGoalsDiff();
         $goalsPlus[] = $row->getGoalsPlus();
      }
      array_multisort($points, SORT_DESC, $goalsDiff, SORT_DESC, $goalsPlus, SORT_DESC, SORT_NUMERIC, $rows);
      $rank = 1;
      foreach ($rows AS $row) {
         $row->setRank($rank);
         $rank++;
      }
      return $rows;
   }
}
?>
