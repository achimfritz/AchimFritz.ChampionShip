<?php
namespace AchimFritz\ChampionShip\User\Domain\Repository;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\User\Domain\Model\User;
use \TYPO3\Flow\Persistence\QueryInterface;

/**
 * A repository for TipGroups
 *
 * @Flow\Scope("singleton")
 */
class TipGroupRepository extends \TYPO3\Flow\Persistence\Repository
{

    /**
     * findByUser
     *
     * @param User $user
     * @return \TYPO3\Flow\Persistence\QueryResultInterface
     */
    public function findByUser(User $user)
    {
        $query = $this->createQuery();
        return $query->matching(
            $query->contains('users', $user)
        )
        ->execute();
    }
}
