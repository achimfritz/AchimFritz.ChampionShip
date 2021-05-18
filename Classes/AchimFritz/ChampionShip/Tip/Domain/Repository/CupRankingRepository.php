<?php
namespace AchimFritz\ChampionShip\Tip\Domain\Repository;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use Neos\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Competition\Domain\Model\Cup;

/**
 * @Flow\Scope("singleton")
 */
class CupRankingRepository extends AbstractRankingRepository
{


    /**
     * @param \Neos\Flow\Persistence\QueryResultInterface|array $users
     * @param Cup $cup
     * @return \Neos\Flow\Persistence\QueryResultInterface
     */
    public function findByUsersAndCup($users, Cup $cup)
    {
        $identifiers = array();
        foreach ($users as $user) {
            $identifiers[] = $this->persistenceManager->getIdentifierByObject($user);
        }
        $query = $this->createQuery();
        return $query->matching(
            $query->logicalAnd(
                $query->in('user', $identifiers),
                $query->equals('cup', $cup)
                )
            )
        ->execute();
    }
}
