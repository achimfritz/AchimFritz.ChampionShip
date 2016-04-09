<?php
namespace AchimFritz\ChampionShip\Domain\Policy\GroupTable;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Domain\Model\GroupTableRow;

/**
 * FifaPointEqualityPolicy
 *
 *	@Flow\Scope("singleton")
 */
class FifaPointEqualityPolicy extends AbstractPointEqualityPolicy {

   /**
    * rowsAreEquay 
    * 
    * @param GroupTableRow $rowOne 
    * @param GroupTableRow $rowTwo 
    * @return boolean
    */
   protected function rowsAreEqual(GroupTableRow $rowOne, GroupTableRow $rowTwo) {
		$this->addMessage('comparing ' . $rowOne->getTeam()->getName() . ' - ' . $rowTwo->getTeam()->getName());
      if ($rowOne->getPoints() === $rowTwo->getPoints()
         AND $rowOne->getGoalsDiff() === $rowTwo->getGoalsDiff()
         AND $rowOne->getGoalsPlus() === $rowTwo->getGoalsPlus()) {
         return TRUE;
      } else {
         return FALSE;
      }
   }

	/**
	 * getPolicyName 
	 * 
	 * @return string
	 */
	protected function getPolicyName() {
		return 'fifa policy';
	}
}
?>
