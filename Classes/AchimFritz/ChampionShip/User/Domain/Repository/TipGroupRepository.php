<?php
namespace AchimFritz\ChampionShip\User\Domain\Repository;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use Neos\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\User\Domain\Model\User;
use \Neos\Flow\Persistence\QueryInterface;

/**
 * A repository for TipGroups
 *
 * @Flow\Scope("singleton")
 */
class TipGroupRepository extends \Neos\Flow\Persistence\Repository
{

    /**
     * findByUser
     *
     * @param User $user
     * @return \Neos\Flow\Persistence\QueryResultInterface
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
