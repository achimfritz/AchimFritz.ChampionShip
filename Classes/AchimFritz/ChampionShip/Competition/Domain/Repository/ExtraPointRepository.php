<?php
namespace AchimFritz\ChampionShip\Competition\Domain\Repository;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use AchimFritz\ChampionShip\Competition\Domain\Model\Cup;
use AchimFritz\ChampionShip\Competition\Domain\Model\ExtraPoints;
use AchimFritz\ChampionShip\Competition\Domain\Model\Team;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Persistence\Repository;

/**
 * @Flow\Scope("singleton")
 */
class ExtraPointRepository extends Repository
{

    /**
     * @param Cup $cup
     * @param Team $team
     * @return ExtraPoints|NULL
     */
    public function findOneByCupAndTeam(Cup $cup, Team $team)
    {
        $query = $this->createQuery();
        return $query->matching(
            $query->logicalAnd(
                $query->equals('cup', $cup),
                $query->equals('team', $team)
            )
        )->execute()->getFirst();
    }
}
