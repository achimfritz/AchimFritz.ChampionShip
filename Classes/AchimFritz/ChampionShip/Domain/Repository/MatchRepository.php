<?php
namespace AchimFritz\ChampionShip\Domain\Repository;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Domain\Model\Team;
use AchimFritz\ChampionShip\Domain\Model\Cup;

/**
 * A repository for Matches
 *
 * @Flow\Scope("singleton")
 */
class MatchRepository extends \TYPO3\Flow\Persistence\Repository {

	/**
	 * findByTeam
	 * 
	 * @param Team $team
	 * @return \TYPO3\FLOW3\Persistence\QueryResultInterface
	 */
	public function findByTeam(Team $team) {
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
	 * findByTowTeamsAndCup
	 * 
	 * @param Team $hostTeam
	 * @param Team $guestTeam
	 * @return \TYPO3\FLOW3\Persistence\QueryResultInterface
	 */
	public function findByTwoTeamsAndCup(Team $hostTeam, Team $guestTeam, Cup $cup) {
		$query = $this->createQuery();
		return $query->matching(
            $query->logicalAnd(
				$query->equals('hostTeam', $hostTeam),
				$query->equals('guestTeam', $guestTeam),
				$query->equals('cup', $cup)
			)
		)
		->execute();
	}

}
?>
