<?php
namespace AchimFritz\ChampionShip\Domain\Repository;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Domain\Model\GroupRound;

/**
 * A repository for Matches
 *
 * @Flow\Scope("singleton")
 */
class CrossGroupMatchRepository extends KoMatchRepository {

	/**
	 * findOneInGroupRoundWithRank
	 * 
	 * @param \AchimFritz\ChampionShip\Domain\Model\GroupRound $groupRound
	 * @param int $rank
	 * @return \AchimFritz\ChampionShip\Domain\Model\KoMatch
	 */
	public function findOneInGroupRoundWithRank(GroupRound $groupRound, $rank) {
		$query = $this->createQuery();
		return $query->matching(
			$query->logicalOr(
	            $query->logicalAnd(
					$query->equals('hostGroupRound', $groupRound),
					$query->equals('hostGroupRank', $rank)
				),
				$query->logicalAnd(
					$query->equals('guestGroupRound', $groupRound),
					$query->equals('guestGroupRank', $rank)
				)
			)
		)
		->execute()->getFirst();
	}	
}
?>
