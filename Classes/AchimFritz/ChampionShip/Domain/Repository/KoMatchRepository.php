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
class KoMatchRepository extends MatchRepository {

	/**
	 * findOneInGroupRoundWithRank
	 * 
	 * @param \AchimFritz\ChampionShip\Domain\Model\GroupRound $groupRound
	 * @param int $rank
	 * @return \AchimFritz\ChampionShip\Domain\Model\GroupMatch
	 */
	public function findOneInGroupRoundWithRank(GroupRound $groupRound, $rank) {
		$query = $this->createQuery();
		return $query->matching(
			$query->logicalOr(
	            $query->logicalAnd(
					$query->equals('hostParticipant.groupRound', $groupRound),
					$query->equals('hostParticipant.rankOfGroupRound', $rank)
				),
				$query->logicalAnd(
					$query->equals('guestParticipant.groupRound', $groupRound),
					$query->equals('guestParticipant.rankOfGroupRound', $rank)
				)
			)
		)
		->execute()->getFirst();
	}	
}
?>