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
class TeamsOfTwoMatchesMatch extends KoMatch {

   /**
    * @var \AchimFritz\ChampionShip\Domain\Model\KoMatch
    * @ORM\OneToOne
	 * @Flow\Validate(type="NotEmpty")
    */
   protected $hostMatch;

   /**
    * @var boolean
    */
   protected $hostMatchIsWinner;

   /**
    * @var boolean
    */
   protected $guestMatchIsWinner;


   /**
    * @var \AchimFritz\ChampionShip\Domain\Model\KoMatch
    * @ORM\OneToOne
	 * @Flow\Validate(type="NotEmpty")
    */
   protected $guestMatch;

	/**
	 * __construct 
	 * 
	 * @return void
	 */
	public function __construct() {
		$this->hostMatchIsWinner = TRUE;
		$this->guestMatchIsWinner = TRUE;
		return parent::__construct();
	}

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

   /**
    * getGuestMatchIsWinner 
    * 
    * @return boolean
    */
   protected function getGuestMatchIsWinner() {
      return $this->guestMatchIsWinner;
   }

   /**
    * setGuestMatchIsWinner 
    * 
    * @param boolean $guestMatchIsWinner 
    * @return void
    */
   protected function setGuestMatchIsWinner($guestMatchIsWinner) {
      $this->guestMatchIsWinner = $guestMatchIsWinner;
   }

   /**
    * getHostMatchIsWinner 
    * 
    * @return boolean
    */
   protected function getHostMatchIsWinner() {
      return $this->hostMatchIsWinner;
   }

   /**
    * setHostMatchIsWinner 
    * 
    * @param boolean $hostMatchIsWinner 
    * @return void
    */
   protected function setHostMatchIsWinner($hostMatchIsWinner) {
      $this->hostMatchIsWinner = $hostMatchIsWinner;
   }
}
?>
