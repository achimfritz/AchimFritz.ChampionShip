<?php
namespace AchimFritz\ChampionShip\Domain\Factory;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Domain\Model\MatchParticipant;
use AchimFritz\ChampionShip\Domain\Model\Team;
use AchimFritz\ChampionShip\Domain\Model\GroupMatch;


/**
 * A GroupMatchFactory
 *
 * @Flow\Scope("singleton")
 */
class GroupMatchFactory {
		

   /**
    * createFromTeams 
    * 
    * @param Team $host
    * @param Team $guest 
	 * @return \AchimFritz\ChampionShip\Domain\Model\Match
    */
   public function createFromTeams(Team $host, Team $guest) {
      $hostParticipant = new MatchParticipant();
      $hostParticipant->setTeam($host);
      $guestParticipant = new MatchParticipant();
      $guestParticipant->setTeam($guest);
      $match = new GroupMatch();
      $match->setHostParticipant($hostParticipant);
      $match->setGuestParticipant($guestParticipant);
      $match->setStartDate(new \DateTime());
      return $match;
   }
	
	
}
?>
