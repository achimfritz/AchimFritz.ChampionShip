<?php
namespace AchimFritz\ChampionShip\Domain\Factory;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Persistence\Doctrine\QueryResult;
use Doctrine\Common\Collections\ArrayCollection;
use AchimFritz\ChampionShip\Domain\Model\Result;
use AchimFritz\ChampionShip\Domain\Model\Tip;
use AchimFritz\ChampionShip\Domain\Model\TipGroupResultMatrix;
use AchimFritz\ChampionShip\Domain\Model\TipGroupResultMatrixRow;

/**
 * A RankingsFactory
 *
 * @Flow\Scope("singleton")
 */
class TipGroupResultMatrixFactory {

	/**
	 * create 
	 * 
	 * @param QueryResult<\AchimFritz\ChampionShip\Domain\Model\User>
	 * @param QueryResult<\AchimFritz\ChampionShip\Domain\Model\Match>
	 * @return TipGroupResultMatrix
	 */
	public function create(QueryResult $users, QueryResult $matches) {
		$matrix = new TipGroupResultMatrix();
		$usersWithTips = new ArrayCollection();
		// filter users
		foreach ($users AS $user) {
			foreach ($matches AS $match) {
				foreach ($user->getTips() AS $tip) {
					if ($tip->getMatch() === $match && $tip->getResult() instanceof Result) {
						$usersWithTips->add($user);
						continue 3;
					}
				}
			}
		}

		$rows = new ArrayCollection();
		foreach ($matches AS $match) {
			$row = new TipGroupResultMatrixRow();
			$row->setMatch($match);
			$tips = new ArrayCollection();
			foreach ($usersWithTips AS $user) {
				$tipFound = FALSE;
				foreach ($user->getTips() AS $tip) {
					if ($tip->getMatch() === $match) {
						$tipFound = TRUE;
						$tips->add($tip);
						continue;
					}
				}
				if ($tipFound === FALSE) {
					$tips->add(new Tip());
				}
			}
			$row->setTips($tips);
			$rows->add($row);
		}
		$matrix->setUsers($usersWithTips);
		$matrix->setRows($rows);
		return $matrix;
	}
}
?>
