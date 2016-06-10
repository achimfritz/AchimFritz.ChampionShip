<?php
namespace AchimFritz\ChampionShip\Competition\Domain\Policy\GroupTable;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use AchimFritz\ChampionShip\Competition\Domain\Model\ExtraPoint;
use TYPO3\Flow\Annotations as Flow;

/**
 * BestThirdsPolicy
 */
class BestThirdsPolicy {

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\ExtraPointRepository
	 */
	protected $extraPointRepository;

	/**
	 * @param array <\AchimFritz\ChampionShip\Competition\Domain\Model\GroupTableRow>
	 * @return array<\AchimFritz\ChampionShip\Competition\Domain\Model\GroupTableRow>
	 */
	public function updateTable(array $rows) {
		$points = array();
		$goalsDiff = array();
		$goalsPlus = array();
		$names = array();
		$extraPoints = array();
		foreach ($rows AS $name => $row) {
			$points[] = $row->getPoints();
			$goalsDiff[] = $row->getGoalsDiff();
			$goalsPlus[] = $row->getGoalsPlus();
			$names[] = $name;
			$extraPoint = $this->extraPointRepository->findOneByCupAndTeam($row->getGroupRound()->getCup(), $row->getTeam());
			if ($extraPoint instanceof ExtraPoint === TRUE) {
				$extraPoints[] = $extraPoint->getPoints();
			} else {
				$extraPoints[] = 0;
			}
		}
		array_multisort($points, SORT_DESC, $goalsDiff, SORT_DESC, $goalsPlus, SORT_DESC, SORT_NUMERIC, $extraPoints, SORT_DESC, $names, SORT_ASC, $rows);
		$rank = 1;
		foreach ($rows AS $row) {
			$row->setRank($rank);
			$rank++;
		}
		return $rows;
	}

}
