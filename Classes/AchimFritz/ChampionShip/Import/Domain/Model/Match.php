<?php
namespace AchimFritz\ChampionShip\Import\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip.Import".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * A Simple Match
 */
class Match {

   /**
    * @var string 
    * @Flow\Validate(type="NotEmpty")
    */
   protected $cupName;

	/**
	 * @var string
	 */
	protected $startDate;

	/**
	 * @var string
	 */
	protected $homeTeam;

	/**
	 * @var string
	 */
	protected $guestTeam;

	/**
	 * @var string
	 */
	protected $homeTeamShort;

	/**
	 * @var string
	 */
	protected $guestTeamShort;

	/**
	 * @var integer
	 */
	protected $homeGoals;

	/**
	 * @var integer
	 */
	protected $guestGoals;

	/**
	 * The group name
	 * @var string
	 */
	protected $groupName;

	/**
	 * @var string
	 */
	protected $name = '';

	/**
	 * The round type
	 * @var integer
	 */
	protected $roundType;

	/**
	 * Get the Wm two six's cupName
	 *
	 * @return string The Wm two six's cupName
	 */
	public function getCupName() {
		return $this->cupName;
	}

	/**
	 * Sets this Wm two six's cupName
	 *
	 * @param string $cupName The Wm two six's cupName
	 * @return void
	 */
	public function setCupName($cupName) {
		$this->cupName = $cupName;
	}

	/**
	 * Get the Wm two six's home team
	 *
	 * @return string The Wm two six's home team
	 */
	public function getHomeTeam() {
		return $this->homeTeam;
	}

	/**
	 * Sets this Wm two six's home team
	 *
	 * @param string $homeTeam The Wm two six's home team
	 * @return void
	 */
	public function setHomeTeam($homeTeam) {
		$this->homeTeam = $homeTeam;
	}

	/**
	 * Get the Wm two six's guest team
	 *
	 * @return string The Wm two six's guest team
	 */
	public function getGuestTeam() {
		return $this->guestTeam;
	}

	/**
	 * Sets this Wm two six's guest team
	 *
	 * @param string $guestTeam The Wm two six's guest team
	 * @return void
	 */
	public function setGuestTeam($guestTeam) {
		$this->guestTeam = $guestTeam;
	}

	/**
	 * Get the Wm two six's home goals
	 *
	 * @return integer The Wm two six's home goals
	 */
	public function getHomeGoals() {
		return $this->homeGoals;
	}

	/**
	 * Sets this Wm two six's home goals
	 *
	 * @param integer $homeGoals The Wm two six's home goals
	 * @return void
	 */
	public function setHomeGoals($homeGoals) {
		$this->homeGoals = $homeGoals;
	}

	/**
	 * Get the Wm two six's guest goals
	 *
	 * @return integer The Wm two six's guest goals
	 */
	public function getGuestGoals() {
		return $this->guestGoals;
	}

	/**
	 * Sets this Wm two six's guest goals
	 *
	 * @param integer $guestGoals The Wm two six's guest goals
	 * @return void
	 */
	public function setGuestGoals($guestGoals) {
		$this->guestGoals = $guestGoals;
	}

	/**
	 * Get the Wm two six's group name
	 *
	 * @return string The Wm two six's group name
	 */
	public function getGroupName() {
		return $this->groupName;
	}

	/**
	 * Sets this Wm two six's group name
	 *
	 * @param string $groupName The Wm two six's group name
	 * @return void
	 */
	public function setGroupName($groupName) {
		$this->groupName = $groupName;
	}

	/**
	 * Get the Wm two six's round type
	 *
	 * @return integer The Wm two six's round type
	 */
	public function getRoundType() {
		return $this->roundType;
	}

	/**
	 * Sets this Wm two six's round type
	 *
	 * @param integer $roundType The Wm two six's round type
	 * @return void
	 */
	public function setRoundType($roundType) {
		$this->roundType = $roundType;
	}

   /**
    * getHomeTeamShort 
    * 
    * @return string homeTeamShort
    */
   public function getHomeTeamShort() {
      return $this->homeTeamShort;
   }

   /**
    * setHomeTeamShort
    * 
    * @param string $homeTeamShort
    * @return void
    */
   public function setHomeTeamShort($homeTeamShort) {
      $this->homeTeamShort = $homeTeamShort;
   }

   /**
    * getGuestTeamShort 
    * 
    * @return string guestTeamShort
    */
   public function getGuestTeamShort() {
      return $this->guestTeamShort;
   }

   /**
    * setGuestTeamShort
    * 
    * @param string $guestTeamShort
    * @return void
    */
   public function setGuestTeamShort($guestTeamShort) {
      $this->guestTeamShort = $guestTeamShort;
   }

   /**
    * getStartDate 
    * 
    * @return string startDate
    */
   public function getStartDate() {
      return $this->startDate;
   }

   /**
    * setStartDate
    * 
    * @param string $startDate
    * @return void
    */
   public function setStartDate($startDate) {
      $this->startDate = $startDate;
   }

	/**
	 * getName
	 *
	 * @return string name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * setName
	 *
	 * @param string $name
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
	}

}
?>
