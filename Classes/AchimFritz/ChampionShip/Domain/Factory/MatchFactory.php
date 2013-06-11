<?php
namespace AchimFritz\ChampionShip\Domain\Factory;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Domain\Model\MatchParticipant;
use AchimFritz\ChampionShip\Domain\Model\Match;
use AchimFritz\ChampionShip\Domain\Model\KoRound;
use AchimFritz\ChampionShip\Domain\Model\GroupRound;


/**
 * A KoRoundService
 *
 * @Flow\Scope("singleton")
 */
class MatchFactory {
		
	/**
	 * createInKoRoundFromGroupRounds
	 * 
	 * @param \AchimFritz\ChampionShip\Domain\Model\KoRound
	 * @param \AchimFritz\ChampionShip\Domain\Model\GroupRound
	 * @param \AchimFritz\ChampionShip\Domain\Model\GroupRound
	 * @return \AchimFritz\ChampionShip\Domain\Model\Match
	 */
	public function createInKoRoundFromGroupRounds(KoRound $koRound, GroupRound $first, GroupRound $second) {
		$hostParticipant = new MatchParticipant();
		$guestParticipant = new MatchParticipant();
		$hostParticipant->setRankOfGroupRound(1);
		$guestParticipant->setRankOfGroupRound(2);
		$hostParticipant->setGroupRound($first);
		$guestParticipant->setGroupRound($second);
		$match = new Match();
		$match->setHostParticipant($hostParticipant);
		$match->setGuestParticipant($guestParticipant);
		$match->setStartDate(new \DateTime());
		$match->setCup($first->getCup());		
		$match->setRound($koRound);
		return $match;
	}
	
	/**
	 * createFromGroupRounds
	 * 
	 * @param \AchimFritz\ChampionShip\Domain\Model\KoRound
	 * @param \AchimFritz\ChampionShip\Domain\Model\Match
	 * @param \AchimFritz\ChampionShip\Domain\Model\Match
	 * @return \AchimFritz\ChampionShip\Domain\Model\Match
	 */
	public function createInKoRoundFromMatches(KoRound $koRound, Match $first, Match $second) {
		$hostParticipant = new MatchParticipant();
		$guestParticipant = new MatchParticipant();
		$hostParticipant->setWinnerOfMatch($first);
		$guestParticipant->setLooserOfMatch($second);
		$match = new Match();
		$match->setHostParticipant($hostParticipant);
		$match->setGuestParticipant($guestParticipant);
		$match->setStartDate(new \DateTime());
		$match->setCup($first->getCup());
		$match->setRound($koRound);
		return $match;
	}
	
	
}
?>
