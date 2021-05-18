<?php
namespace AchimFritz\ChampionShip\Competition\Domain\Repository;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use Neos\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Competition\Domain\Model\Cup;
use \Neos\Flow\Persistence\QueryInterface;

/**
 * A repository for KoRounds
 *
 * @Flow\Scope("singleton")
 */
class RoundRepository extends \Neos\Flow\Persistence\Repository
{

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->setDefaultOrderings(array('generalMatches.startDate' => QueryInterface::ORDER_ASCENDING));
    }

    
    /**
     * findOneByNameAndCup
     *
     * @param string $name
     * @param Cup $cup
     * @return \Neos\Flow\Persistence\QueryResultInterface
     */
    public function findOneByNameAndCup($name, Cup $cup)
    {
        $query = $this->createQuery();
        return $query->matching(
            $query->logicalAnd(
                $query->equals('name', $name),
                $query->equals('cup', $cup)
            )
        )
        ->execute()->getFirst();
    }
}
