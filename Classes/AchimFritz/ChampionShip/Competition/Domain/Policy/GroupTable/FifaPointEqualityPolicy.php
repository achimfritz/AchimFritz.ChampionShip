<?php
namespace AchimFritz\ChampionShip\Competition\Domain\Policy\GroupTable;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use Neos\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Competition\Domain\Model\GroupTableRow;

/**
 * FifaPointEqualityPolicy
 *
 *	@Flow\Scope("singleton")
 */
class FifaPointEqualityPolicy extends AbstractPointEqualityPolicy
{

   /**
    * rowsAreEquay
    *
    * @param GroupTableRow $rowOne
    * @param GroupTableRow $rowTwo
    * @return boolean
    */
    protected function rowsAreEqual(GroupTableRow $rowOne, GroupTableRow $rowTwo)
    {
        $this->addMessage('comparing ' . $rowOne->getTeam()->getName() . ' - ' . $rowTwo->getTeam()->getName());
        if ($rowOne->getPoints() === $rowTwo->getPoints()
         and $rowOne->getGoalsDiff() === $rowTwo->getGoalsDiff()
         and $rowOne->getGoalsPlus() === $rowTwo->getGoalsPlus()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * getPolicyName
     *
     * @return string
     */
    protected function getPolicyName()
    {
        return 'fifa policy';
    }
}
