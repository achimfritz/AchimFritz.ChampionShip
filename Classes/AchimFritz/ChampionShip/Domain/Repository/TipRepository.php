<?php
namespace AchimFritz\ChampionShip\Domain\Repository;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Domain\Model\User;
use AchimFritz\ChampionShip\Domain\Model\Cup;
use AchimFritz\ChampionShip\Domain\Model\Round;
use \TYPO3\Flow\Persistence\Repository;
use \TYPO3\Flow\Persistence\QueryInterface;

/**
 * A repository for TipGroups
 *
 * @Flow\Scope("singleton")
 */
class TipRepository extends Repository {

	/**
	 * __construct 
	 * 
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
		$this->setDefaultOrderings(array('generalMatch.startDate' => QueryInterface::ORDER_ASCENDING));
	}

	/**
	 * findByCup 
	 * 
	 * @param Cup $cup 
	 * @param User $user
	 * @return \TYPO3\FLOW3\Persistence\QueryResultInterface
	 */
	public function findByUserInCup(User $user, Cup $cup) {
		$query = $this->createQuery();
		return $query->matching(
         $query->logicalAnd(
				$query->equals('generalMatch.cup', $cup),
				$query->equals('user', $user)
				#$query->logicalNot($query->isEmpty('result'))
			)
		)
		->execute();
	}

	/**
	 * findByCup 
	 * 
	 * @param Cup $cup 
	 * @return \TYPO3\FLOW3\Persistence\QueryResultInterface
	 */
	public function findByCup(Cup $cup) {
		$query = $this->createQuery();
		return $query->matching(
			$query->equals('generalMatch.cup', $cup)
		)
		->execute();
	}

	/**
	 * findOneUserInMatches
	 * 
	 * @param User $user 
	 * @param mixed $matches
	 * @return \TYPO3\FLOW3\Persistence\QueryResultInterface
	 */
	public function findByUserInMatches(User $user, $matches) {
		$query = $this->createQuery();
		// bad hack ($query->in works not)
		$c = array();
		foreach ($matches AS $match) {
			$c[] = $query->equals('generalMatch', $match);
		}
		if (count($c)) {
			return $query->matching(
				$query->logicalAnd(
					$query->logicalOr($c),
					$query->equals('user', $user)
					)
				)
			->execute();
		} else {
			return array();
		}
	}

	/**
	 * findOneByUserAndMatch 
	 * 
	 * @param User $user 
	 * @param Match $match 
	 * @return \TYPO3\FLOW3\Persistence\QueryResultInterface
	 */
	public function findOneByUserAndMatch(User $user, Match $match) {
		$query = $this->createQuery();
		return $query->matching(
            $query->logicalAnd(
				$query->equals('generalMatch', $match),
				$query->equals('user', $user)
			)
		)
		->execute()->getFirst();
	}

	/**
	 * findMatchTipsByUserInRound 
	 * 
	 * @param User $user 
	 * @param GroupRound $round 
	 * @return ArrayCollection
	 */
	public function findByUserInRound(User $user, Round $round) {
		$query = $this->createQuery();
		return $query->matching(
         $query->logicalAnd(
				$query->equals('generalMatch.round', $round),
				$query->equals('user', $user)
			)
		)->execute();
	}
}
?>
