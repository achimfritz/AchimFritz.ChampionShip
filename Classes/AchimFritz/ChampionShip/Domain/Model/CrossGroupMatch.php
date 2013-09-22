<?php
namespace AchimFritz\ChampionShip\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;
use AchimFritz\ChampionShip\Domain\Model\GroupRound;

/**
 * A Match
 *
 * @Flow\Entity
 */
class CrossGroupMatch extends KoMatch {

   /**
    * @var \AchimFritz\ChampionShip\Domain\Model\GroupRound
    * @ORM\ManyToOne
	 * @Flow\Validate(type="NotEmpty")
    */
   protected $hostGroupRound;

   /**
    * @var integer
	 * @Flow\Validate(type="NotEmpty")
    */
   protected $hostGroupRank;

   /**
    * @var \AchimFritz\ChampionShip\Domain\Model\GroupRound
    * @ORM\ManyToOne
	 * @Flow\Validate(type="NotEmpty")
    */
   protected $guestGroupRound;

   /**
    * @var integer
	 * @Flow\Validate(type="NotEmpty")
    */
   protected $guestGroupRank;

   /**
    * getHostGroupRound 
    * 
    * @return GroupRound hostGroupRound
    */
   public function getHostGroupRound() {
      return $this->hostGroupRound;
   }

   /**
    * setHostGroupRound
    * 
    * @param GroupRound $hostGroupRound
    * @return void
    */
   public function setHostGroupRound(GroupRound $hostGroupRound) {
      $this->hostGroupRound = $hostGroupRound;
   } 

   /**
    * getGuestGroupRound 
    * 
    * @return GroupRound guestGroupRound
    */
   public function getGuestGroupRound() {
      return $this->guestGroupRound;
   }

   /**
    * setGuestGroupRound
    * 
    * @param GroupRound $guestGroupRound
    * @return void
    */
   public function setGuestGroupRound(GroupRound $guestGroupRound) {
      $this->guestGroupRound = $guestGroupRound;
   } 

   /**
    * setHostGroupRank 
    * 
    * @param integer $hostGroupRank 
    * @return void
    */
   public function setHostGroupRank($hostGroupRank) {
      $this->hostGroupRank = $hostGroupRank;
   }

   /**
    * getHostGroupRank 
    * 
    * @return integer
    */
   public function getHostGroupRank() {
      return $this->hostGroupRank;
   }

   /**
    * setGuestGroupRank 
    * 
    * @param integer $guestGroupRank 
    * @return void
    */
   public function setGuestGroupRank($guestGroupRank) {
      $this->guestGroupRank = $guestGroupRank;
   }

   /**
    * getGuestGroupRank 
    * 
    * @return integer
    */
   public function getGuestGroupRank() {
      return $this->guestGroupRank;
   }

}
?>
