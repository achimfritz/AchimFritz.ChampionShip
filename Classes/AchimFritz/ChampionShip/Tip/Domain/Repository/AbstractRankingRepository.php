<?php
namespace AchimFritz\ChampionShip\Tip\Domain\Repository;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Persistence\Repository;
use Neos\Flow\Persistence\QueryInterface;

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
     * @param \Neos\Flow\Persistence\QueryResultInterface|array $users
     * @return \Neos\Flow\Persistence\QueryResultInterface
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
