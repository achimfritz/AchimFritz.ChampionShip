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
use \Doctrine\Common\Collections\ArrayCollection;

/**
 * A repository for TipGroups
 *
 * @Flow\Scope("singleton")
 */
class TipRepository extends Repository {

	/**
	 * @var \AchimFritz\ChampionShip\Domain\Repository\MatchRepository
	 * @Flow\Inject
	 */
	protected $matchRepository;

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
	 * findGroupMatchTipsByUserInCup
	 * 
	 * @param User $user 
	 * @param Cup $cup
	 * @return ArrayCollection
	 */
	public function findGroupMatchTipsByUserInCup(User $user, Cup $cup) {
		// TODO and Cup?
		// TODO this are all tips not only GroupMatch
		$all = $this->findByUser($user);
		$tips = new ArrayCollection();
		$matches = $this->matchRepository->findByCup($cup);
		foreach ($matches AS $match) {
			foreach ($all AS $tip) {
				if ($tip->getMatch() === $match) {
					$tips->add($tip);
					continue;
				}
			}
		}
		if (count($tips) != count($matches)) {
			// TODO
		}
		return $tips;
	}

	/**
	 * findMatchTipsByUserInRound 
	 * 
	 * @param User $user 
	 * @param GroupRound $round 
	 * @return ArrayCollection
	 */
	public function findMatchTipsByUserInRound(User $user, Round $round) {
		// TODO and Cup?
		$all = $this->findByUser($user);
		$tips = new ArrayCollection();
		$matches = $this->matchRepository->findByRound($round);
		foreach ($matches AS $match) {
			foreach ($all AS $tip) {
				if ($tip->getMatch() === $match) {
					$tips->add($tip);
					continue;
				}
			}
		}
		if (count($tips) != count($matches)) {
			// TODO
		}
		return $tips;
	}
}
?>
