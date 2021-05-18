<?php
namespace AchimFritz\ChampionShip\Competition\Domain\Repository;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use Neos\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Competition\Domain\Model\Result;
use AchimFritz\ChampionShip\Competition\Domain\Model\Team;
use AchimFritz\ChampionShip\Competition\Domain\Model\Cup;
use Neos\Flow\Persistence\QueryInterface;

/**
 * A repository for Matches
 *
 * @Flow\Scope("singleton")
 */
class MatchRepository extends \Neos\Flow\Persistence\Repository
{

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->setDefaultOrderings(array('startDate' => QueryInterface::ORDER_ASCENDING));
    }

    /**
     * findByTeam
     *
     * @param Team $team
     * @return \Neos\Flow\Persistence\QueryResultInterface
     */
    public function findByTeam(Team $team)
    {
        $query = $this->createQuery();
        return $query->matching(
            $query->logicalOr(
                $query->equals('hostTeam', $team),
                $query->equals('guestTeam', $team)
            )
        )
        ->execute();
    }

    /**
     * findOneByTowTeamsAndCup
     *
     * @param Team $team
     * @param Team $otherTeam
     * @return \Neos\Flow\Persistence\QueryResultInterface
     */
    public function findOneByTwoTeamsAndCup(Team $team, Team $otherTeam, Cup $cup)
    {
        return $this->findByTwoTeamsAndCup($team, $otherTeam, $cup)->getFirst();
    }

    /**
     * findByTowTeamsAndCup
     *
     * @param Team $team
     * @param Team $otherTeam
     * @param Cup $cup
     * @return \Neos\Flow\Persistence\QueryResultInterface
     */
    public function findByTwoTeamsAndCup(Team $team, Team $otherTeam, Cup $cup)
    {
        $query = $this->createQuery();
        return $query->matching(
            $query->logicalAnd(
                    $query->logicalOr(
                        $query->logicalAnd(
                            $query->equals('hostTeam', $team),
                            $query->equals('guestTeam', $otherTeam)
                        ),
                        $query->logicalAnd(
                            $query->equals('guestTeam', $team),
                            $query->equals('hostTeam', $otherTeam)
                        )
                    ),
                    $query->equals('cup', $cup)
                )
        )
        ->execute();
    }

    /**
     * findOneByNameAndCup
     *
     * @param string $name
     * @param Cup $cup
     * @return Match|NULL
     */
    public function findOneByNameAndCup($name, Cup $cup)
    {
        $query = $this->createQuery();
        return $query->matching(
            $query->logicalAnd(
                    $query->equals('cup', $cup),
                    $query->equals('name', $name)
                )
        )
        ->execute()->getFirst();
    }

    /**
     * findLastByCup
     *
     * @param Cup $cup
     * @param integer $limit
     * @return \Neos\Flow\Persistence\QueryResultInterface
     */
    public function findLastByCup(Cup $cup, $limit = 2)
    {
        $query = $this->createQuery();
        $query->setOrderings(array('startDate' => QueryInterface::ORDER_DESCENDING));
        $now = new \DateTime();
        $result = $query->setLimit($limit)->matching(
            $query->logicalAnd(
                $query->equals('cup', $cup),
                $query->lessThan('startDate', $now)
            )
        )
        ->execute();
        return $result;
    }

    /**
     * findNextByCup
     *
     * @param Cup $cup
     * @param integer $limit
     * @return \Neos\Flow\Persistence\QueryResultInterface
     */
    public function findNextByCup(Cup $cup, $limit = 2)
    {
        $query = $this->createQuery();
        $now = new \DateTime();
        $result = $query->setLimit($limit)->matching(
            $query->logicalAnd(
                $query->equals('cup', $cup),
                $query->greaterThan('startDate', $now)
            )
        )
        ->execute();
        return $result;
    }

    /**
     * @return \Neos\Flow\Persistence\QueryResultInterface
     */
    public function findInFuture()
    {
        $query = $this->createQuery();
        $now = new \DateTime();
        return $query->matching(
            $query->greaterThan('startDate', $now)
        )->execute();
    }
}
