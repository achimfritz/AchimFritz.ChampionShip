<?php
namespace AchimFritz\ChampionShip\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;
use AchimFritz\ChampionShip\Domain\Model\KoMatch;

/**
 * A Match
 *
 * @Flow\Entity
 */
class WinnersOfTwoMatchesMatch extends KoMatch {

   /**
    * @var \AchimFritz\ChampionShip\Domain\Model\KoMatch
    * @ORM\OneToOne
	 * @Flow\Validate(type="NotEmpty")
    */
   protected $hostMatch;

   /**
    * @var \AchimFritz\ChampionShip\Domain\Model\KoMatch
    * @ORM\OneToOne
	 * @Flow\Validate(type="NotEmpty")
    */
   protected $guestMatch;

   /**
    * getHostMatch 
    * 
    * @return KoMatch hostMatch
    */
   public function getHostMatch() {
      return $this->hostMatch;
   }

   /**
    * setHostMatch
    * 
    * @param KoMatch $hostMatch
    * @return void
    */
   public function setHostMatch(KoMatch $hostMatch) {
      $this->hostMatch = $hostMatch;
   } 

   /**
    * getGuestMatch 
    * 
    * @return KoMatch guestMatch
    */
   public function getGuestMatch() {
      return $this->guestMatch;
   }

   /**
    * setGuestMatch
    * 
    * @param KoMatch $guestMatch
    * @return void
    */
   public function setGuestMatch(KoMatch $guestMatch) {
      $this->guestMatch = $guestMatch;
   } 
}
?>
