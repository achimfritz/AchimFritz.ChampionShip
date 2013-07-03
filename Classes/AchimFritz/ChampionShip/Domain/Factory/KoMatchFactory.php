<?php
namespace AchimFritz\ChampionShip\Domain\Factory;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Domain\Model\KoMatch;
use AchimFritz\ChampionShip\Domain\Model\MatchParticipant;
use AchimFritz\ChampionShip\Domain\Model\Team;
use AchimFritz\ChampionShip\Domain\Model\GroupRound;


/**
 * A KoMatchFactory
 *
 * @Flow\Scope("singleton")
 */
class KoMatchFactory {

	/**
	 * createFromGroupRounds
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\GroupRound
	 * @param \AchimFritz\ChampionShip\Domain\Model\GroupRound
	 * @return \AchimFritz\ChampionShip\Domain\Model\KoMatch
	 */
	public function createFromGroupRounds(GroupRound $first, GroupRound $second) {
		$hostParticipant = new MatchParticipant();
		$guestParticipant = new MatchParticipant();
		$hostParticipant->setRankOfGroupRound(1);
		$guestParticipant->setRankOfGroupRound(2);
		$hostParticipant->setGroupRound($first);
		$guestParticipant->setGroupRound($second);
		$match = new KoMatch();
		$match->setHostParticipant($hostParticipant);
		$match->setGuestParticipant($guestParticipant);
		$match->setStartDate(new \DateTime());
		$match->setCup($first->getCup());
		return $match;
	}

	/**
	 * createFromMatches
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\KoMatch
	 * @param \AchimFritz\ChampionShip\Domain\Model\KoMatch
	 * @return \AchimFritz\ChampionShip\Domain\Model\KoMatch
	 */
	public function createFromWinners(KoMatch $first, KoMatch $second) {
		$hostParticipant = new MatchParticipant();
		$guestParticipant = new MatchParticipant();
		$hostParticipant->setWinnerOfMatch($first);
		$guestParticipant->setWinnerOfMatch($second);
		$match = new KoMatch();
		$match->setHostParticipant($hostParticipant);
		$match->setGuestParticipant($guestParticipant);
		$match->setStartDate(new \DateTime());
		$match->setCup($first->getCup());
		return $match;
	}

	/**
	 * createFromTeams
	 *
	 * @param Team $host
	 * @param Team $guest
	 * @return \AchimFritz\ChampionShip\Domain\Model\KoMatch
	 */
	public function createFromTeams(Team $host, Team $guest) {
		$hostParticipant = new MatchParticipant();
		$hostParticipant->setTeam($host);
		$guestParticipant = new MatchParticipant();
		$guestParticipant->setTeam($guest);
		$match = new KoMatch();
		$match->setHostParticipant($hostParticipant);
		$match->setGuestParticipant($guestParticipant);
		$match->setStartDate(new \DateTime());
		return $match;
	}

}
?>
