<?php
namespace AchimFritz\ChampionShip\Competition\Domain\Repository;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use Neos\Flow\Annotations as Flow;

/**
 * A repository for Cups
 *
 * @Flow\Scope("singleton")
 */
class CupRepository extends \Neos\Flow\Persistence\Repository
{

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->setDefaultOrderings(array('startDate' => \Neos\Flow\Persistence\QueryInterface::ORDER_ASCENDING));
    }

    /**
     * @return \AchimFritz\ChampionShip\Competition\Domain\Model\Cup
     */
    public function findOneRecent()
    {
        $query = $this->createQuery();
        $query->setOrderings(array('startDate' => \Neos\Flow\Persistence\QueryInterface::ORDER_DESCENDING));
        return $query->execute()->getFirst();
    }
}
