<?php
namespace AchimFritz\ChampionShip\Tip\Domain\Repository;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Persistence\Repository;
use TYPO3\Flow\Persistence\QueryInterface;

/**
 * A repository for TipGroups
 *
 * @Flow\Scope("singleton")
 */
abstract class AbstractRankingRepository extends Repository
{

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->setDefaultOrderings(array('rank' => QueryInterface::ORDER_ASCENDING));
    }

    /**
     * @param \TYPO3\Flow\Persistence\QueryResultInterface|array $users
     * @return \TYPO3\Flow\Persistence\QueryResultInterface
     */
    public function findByUsers($users)
    {
        $identifiers = array();
        foreach ($users as $user) {
            $identifiers[] = $this->persistenceManager->getIdentifierByObject($user);
        }
        $query = $this->createQuery();
        return $query->matching(
                $query->in('user', $identifiers)
            )
        ->execute();
    }
}
