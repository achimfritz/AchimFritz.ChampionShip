<?php
namespace AchimFritz\ChampionShip\Competition\Domain\Factory;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Competition\Domain\Model\CrossGroupMatch;
use AchimFritz\ChampionShip\Competition\Domain\Model\TeamsOfTwoMatchesMatch;
use AchimFritz\ChampionShip\Competition\Domain\Model\KoMatch;
use AchimFritz\ChampionShip\Competition\Domain\Model\GroupRound;


/**
 * A KoMatchFactory
 *
 * @Flow\Scope("singleton")
 */
class KoMatchFactory {

	/**
	 * createFromGroupRounds
	 *
	 * @param \AchimFritz\ChampionShip\Competition\Domain\Model\GroupRound
	 * @param \AchimFritz\ChampionShip\Competition\Domain\Model\GroupRound
	 * @return \AchimFritz\ChampionShip\Competition\Domain\Model\CrossGroupMatch
	 */
	public function createFromGroupRounds(GroupRound $first, GroupRound $second) {
		$match = new CrossGroupMatch();
		$match->setHostGroupRound($first);
		$match->setHostGroupRank(1);
		$match->setGuestGroupRound($second);
		$match->setGuestGroupRank(2);
		$match->setStartDate(new \DateTime());
		$match->setCup($first->getCup());
		return $match;
	}

	/**
	 * createFromMatches
	 *
	 * @param \AchimFritz\ChampionShip\Competition\Domain\Model\KoMatch
	 * @param \AchimFritz\ChampionShip\Competition\Domain\Model\KoMatch
	 * @return \AchimFritz\ChampionShip\Competition\Domain\Model\TeamsOfTwoMatchesMatch
	 */
	public function createFromWinners(KoMatch $first, KoMatch $second) {
		$match = new TeamsOfTwoMatchesMatch();
		$match->setHostMatch($first);
		$match->setHostMatchIsWinner(TRUE);
		$match->setGuestMatch($second);
		$match->setGuestMatchIsWinner(TRUE);
		$match->setStartDate(new \DateTime());
		$match->setCup($first->getCup());
		return $match;
	}
}
?>
