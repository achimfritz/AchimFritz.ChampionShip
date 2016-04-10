<?php
namespace AchimFritz\ChampionShip\Competition\Domain\Policy\GroupTable;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;


/**
 * DefaultPolicy
 */
class DefaultPolicy {

   /**
    * updateTable
    * 
    * @param array<\AchimFritz\ChampionShip\Competition\Domain\Model\GroupTableRow>
    * @return array<\AchimFritz\ChampionShip\Competition\Domain\Model\GroupTableRow>
    */
   public function updateTable(array $rows) {
      $points = array();
      $goalsDiff = array();
      $goalsPlus = array();
		$names = array();
      foreach ($rows AS $name => $row) {
         $points[] = $row->getPoints();
         $goalsDiff[] = $row->getGoalsDiff();
         $goalsPlus[] = $row->getGoalsPlus();
			$names[] = $name;
      }
      array_multisort($points, SORT_DESC, $goalsDiff, SORT_DESC, $goalsPlus, SORT_DESC, SORT_NUMERIC, $names, SORT_ASC, $rows);
      $rank = 1;
      foreach ($rows AS $row) {
         $row->setRank($rank);
         $rank++;
      }
      return $rows;
   }

}
?>
