<?php
namespace AchimFritz\ChampionShip\Tip\Domain\Repository;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Competition\Domain\Model\Match;
use AchimFritz\ChampionShip\User\Domain\Model\User;
use AchimFritz\ChampionShip\Competition\Domain\Model\Cup;
use AchimFritz\ChampionShip\Competition\Domain\Model\Round;
use \TYPO3\Flow\Persistence\Repository;
use \TYPO3\Flow\Persistence\QueryInterface;

/**
 * A repository for TipGroups
 *
 * @Flow\Scope("singleton")
 */
class TipRepository extends Repository {

	/**
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
		$this->setDefaultOrderings(array('generalMatch.startDate' => QueryInterface::ORDER_ASCENDING));
	}

	/**
	 * @param Cup $cup
	 * @param User $user
	 * @return \TYPO3\Flow\Persistence\QueryResultInterface
	 */
	public function findByUserInCupWithResult(User $user, Cup $cup) {
		$query = $this->createQuery();
		return $query->matching(
			$query->logicalAnd(
				$query->equals('generalMatch.cup', $cup),
				$query->equals('user', $user),
				$query->logicalNot($query->equals('result', NULL))
			)
		)
			->execute();
	}

	/**
	 * @param Cup $cup 
	 * @param User $user
	 * @return \TYPO3\Flow\Persistence\QueryResultInterface
	 */
	public function findByUserInCup(User $user, Cup $cup) {
		$query = $this->createQuery();
		return $query->matching(
         $query->logicalAnd(
				$query->equals('generalMatch.cup', $cup),
				$query->equals('user', $user)
			)
		)
		->execute();
	}

	/**
	 * @param Cup $cup 
	 * @return \TYPO3\Flow\Persistence\QueryResultInterface
	 */
	public function findByCup(Cup $cup) {
		$query = $this->createQuery();
		return $query->matching(
			$query->equals('generalMatch.cup', $cup)
		)
		->execute();
	}

	/**
	 * @param User $user 
	 * @param mixed $matches
	 * @return \TYPO3\Flow\Persistence\QueryResultInterface
	 */
	public function findByUserInMatches(User $user, $matches) {
		$identifiers = array();
		foreach ($matches as $match) {
			$identifiers[] = $this->persistenceManager->getIdentifierByObject($match);
		}
		$query = $this->createQuery();
		return $query->matching(
			$query->logicalAnd(
				$query->in('generalMatch', $identifiers),
				$query->equals('user', $user)
			)
		)->execute();
	}

	/**
	 * @param \AchimFritz\ChampionShip\User\Domain\Model\User $user
	 * @param \AchimFritz\ChampionShip\Competition\Domain\Model\Match $match
	 * @return \AchimFritz\ChampionShip\Tip\Domain\Model\Tip
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
	 * @param \TYPO3\Flow\Persistence\QueryResultInterface $users
	 * @param Match $match
	 * @return \TYPO3\Flow\Persistence\QueryResultInterface
	 */
	public function findByUsersAndMatch(\TYPO3\Flow\Persistence\QueryResultInterface $users, Match $match) {
		$identifiers = array();
		foreach ($users as $user) {
			$identifiers[] = $this->persistenceManager->getIdentifierByObject($user);
		}
		$query = $this->createQuery();
		return $query->matching(
			$query->logicalAnd(
				$query->equals('generalMatch', $match),
				$query->in('user', $identifiers)
			)
		)
			->execute();
	}

	/**
	 * @param User $user 
	 * @param Round $round
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

	/**
	 * @param Round $round
	 * @return ArrayCollection
	 */
	public function findByRound(Round $round) {
		$query = $this->createQuery();
		return $query->matching(
			$query->equals('generalMatch.round', $round)
		)->execute();
	}

}
