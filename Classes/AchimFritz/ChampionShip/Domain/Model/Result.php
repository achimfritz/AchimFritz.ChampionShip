<?php
namespace AchimFritz\ChampionShip\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * A Result
 *
 * @Flow\Entity
 */
class Result {

	/**
	 * The host team goals
	 * @var integer
	 * @Flow\Validate(type="NotEmpty")
	 */
	protected $hostTeamGoals;

	/**
	 * The guest team goals
	 * @var integer
	 * @Flow\Validate(type="NotEmpty")
	 */
	protected $guestTeamGoals;


	/**
	 * Get the Result's host team goals
	 *
	 * @return integer The Result's host team goals
	 */
	public function getHostTeamGoals() {
		return $this->hostTeamGoals;
	}

	/**
	 * Sets this Result's host team goals
	 *
	 * @param integer $hostTeamGoals The Result's host team goals
	 * @return void
	 */
	public function setHostTeamGoals($hostTeamGoals) {
		$this->hostTeamGoals = $hostTeamGoals;
	}

	/**
	 * Get the Result's guest team goals
	 *
	 * @return integer The Result's guest team goals
	 */
	public function getGuestTeamGoals() {
		return $this->guestTeamGoals;
	}

	/**
	 * Sets this Result's guest team goals
	 *
	 * @param integer $guestTeamGoals The Result's guest team goals
	 * @return void
	 */
	public function setGuestTeamGoals($guestTeamGoals) {
		$this->guestTeamGoals = $guestTeamGoals;
	}

   /**
    * getGuestPoints 
    * 
    * @return integer
    */
   public function getGuestPoints() {
      if ($this->getGuestWins()) {
         return 3;
      } elseif ($this->getHostWins()) {
         return 0;
      } elseif ($this->getIsRemis()) {
         return 1;
      }
   }

   /**
    * getHostPoints 
    * 
    * @return integer
    */
   public function getHostPoints() {
      if ($this->getGuestWins()) {
         return 0;
      } elseif ($this->getHostWins()) {
         return 3;
      } elseif ($this->getIsRemis()) {
         return 1;
      }
   }

   /**
    * getHostWins 
    * 
    * @return boolean
    */
   public function getHostWins(){
      return ($this->hostTeamGoals > $this->guestTeamGoals);
   }

   /**
    * getGuestWins 
    * 
    * @return boolean
    */
   public function getGuestWins() {
      return ($this->hostTeamGoals < $this->guestTeamGoals);
   }

   /**
    * getIsRemis 
    * 
    * @return boolean
    */
   public function getIsRemis() {
      return ($this->hostTeamGoals === $this->guestTeamGoals);
   }

}
?>
