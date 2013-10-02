<?php
namespace AchimFritz\ChampionShip\Domain\Repository;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Domain\Model\Team;
use AchimFritz\ChampionShip\Domain\Model\Cup;
use \TYPO3\Flow\Persistence\QueryInterface;

/**
 * A repository for Matches
 *
 * @Flow\Scope("singleton")
 */
class MatchRepository extends \TYPO3\Flow\Persistence\Repository {

	/**
	 * __construct 
	 * 
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
		$this->setDefaultOrderings(array('startDate' => QueryInterface::ORDER_ASCENDING));
	}

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
	 * findOneByTowTeamsAndCup
	 * 
	 * @param Team $team
	 * @param Team $otherTeam
	 * @return \TYPO3\FLOW3\Persistence\QueryResultInterface
	 */
	public function findOneByTwoTeamsAndCup(Team $team, Team $otherTeam, Cup $cup) {
		return $this->findByTwoTeamsAndCup($team, $otherTeam, $cup)->getFirst();
	}

	/**
	 * findByTowTeamsAndCup
	 * 
	 * @param Team $team
	 * @param Team $otherTeam
	 * @return \TYPO3\FLOW3\Persistence\QueryResultInterface
	 */
	public function findByTwoTeamsAndCup(Team $team, Team $otherTeam, Cup $cup) {
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

}
?>
