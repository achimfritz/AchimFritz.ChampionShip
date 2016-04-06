<?php
namespace AchimFritz\ChampionShip\Domain\Factory;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Domain\Model\MatchParticipant;
use AchimFritz\ChampionShip\Competition\Domain\Model\Team;
use AchimFritz\ChampionShip\Competition\Domain\Model\GroupMatch;


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
      $match = new GroupMatch();
      $match->setHostTeam($host);
      $match->setGuestTeam($guest);
      $match->setStartDate(new \DateTime());
      return $match;
   }
	
	
}
?>
