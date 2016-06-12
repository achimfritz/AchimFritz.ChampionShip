<?php
namespace AchimFritz\ChampionShip\Competition\Domain\Service;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use AchimFritz\ChampionShip\Competition\Domain\Model\Cup;
use AchimFritz\ChampionShip\Competition\Domain\Policy\GroupTable\BestThirdsPolicy;
use TYPO3\Flow\Annotations as Flow;


/**
 * @Flow\Scope("singleton")
 */
class GroupRoundService {

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\GroupRoundRepository
	 */
	protected $groupRoundRepository;

	/**
	 * @param Cup $cup
	 * @return void
	 * @throws Exception
	 */
	public function finish(Cup $cup) {
		// group table
		$groupTableRows = $this->buildGroupTableRows($cup);
		// string by alpha sort -> A C D E
		$roundString = $this->buildRoundsString($groupTableRows);
		$policy = $this->getPolicy();
		$roundMatrix = $policy->getRoundMatrix();
		if (empty($roundMatrix[$roundString]) === TRUE) {
			throw new Exception('no matrix round found for ' . $roundString, 1464109832);
		}
		$combination = $roundMatrix[$roundString];


		// collect groups
		// string by alpha sort -> A C D E
		// A C D E         C       D       A       E
		// Spiel mit 1. Gruppe A -> 3 C
		// Spiel mit 1. Gruppe B -> 3 D
		// Spiel mit 1. Gruppe C -> 3 A
		// Spiel mit 1. Gruppe D -> 3 E

		return $groupTableRows;
	}


	/**
	 * @param $groupTableRows
	 * @return void
	 */
	protected function buildRoundsString($groupTableRows) {
		$rounds = array();
		foreach ($groupTableRows as $groupTableRow) {
			$rounds[] = $groupTableRow->getGroupRound()->getName();
		}
		sort($rounds);
		return implode('', $rounds);
	}

	/**
	 * @param Cup $cup
	 * @return array
	 * @throws Exception
	 */
	protected function buildGroupTableRows(Cup $cup) {
		$groupRounds = $this->groupRoundRepository->findByCup($cup);
		$groupTableRows = array();
		foreach ($groupRounds as $groupRound) {
			if ($groupRound->getRoundIsFinished() === FALSE) {
				throw new Exception('groupRound not finished ' . $groupRound->getName(), 1464109831);
			}
			$groupTableRows[] = $groupRound->getGroupTableRowByRank(3);
		}
		$policy = $this->getPolicy();
		$groupTableRows = $policy->updateTable($groupTableRows);
		// 1-4
		$groupTableRows = array_slice($groupTableRows, 0, 4);
		return $groupTableRows;
	}

	/**
	 * @return BestThirdsPolicy
	 */
	protected function getPolicy() {
		return new BestThirdsPolicy();
	}
}

