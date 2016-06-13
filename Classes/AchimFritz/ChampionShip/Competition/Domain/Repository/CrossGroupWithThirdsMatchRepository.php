<?php
namespace AchimFritz\ChampionShip\Competition\Domain\Repository;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use AchimFritz\ChampionShip\Competition\Domain\Model\Cup;
use AchimFritz\ChampionShip\Competition\Domain\Model\CrossGroupWithThirdsMatch;
use TYPO3\Flow\Annotations as Flow;

/**
 * A repository for Matches
 *
 * @Flow\Scope("singleton")
 */
class CrossGroupWithThirdsMatchRepository extends CrossGroupMatchRepository {

	/**
	 * @param Cup $cup
	 * @param $roundName
	 * @return CrossGroupWithThirdsMatch|NULL
	 */
	public function findOneByCupAndRoundName(Cup $cup, $roundName) {
		$query = $this->createQuery();
		/*
		return $query->matching(
			$query->logicalAnd(
				$query->equals('cup', $cup),
				$query->equals('hostGroupRank', '1')
			)
		)->execute()->getFirst();
		*/

		return $query->matching(
			$query->logicalAnd(
				$query->equals('cup', $cup),
				$query->equals('hostGroupRank', 1),
				$query->equals('hostGroupRound.name', $roundName)
			)
		)->execute()->getFirst();

	}

}
