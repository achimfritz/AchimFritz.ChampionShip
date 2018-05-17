<?php
namespace AchimFritz\ChampionShip\Competition\Domain\Policy\GroupTable;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Competition\Domain\Model\GroupTableRow;

/**
 * UefaPointEqualityPolicy
 *
 *	@Flow\Scope("singleton")
 */
class UefaPointEqualityPolicy extends AbstractPointEqualityPolicy
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
        if ($rowOne->getPoints() === $rowTwo->getPoints()) {
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
        return 'uefa policy';
    }
}
