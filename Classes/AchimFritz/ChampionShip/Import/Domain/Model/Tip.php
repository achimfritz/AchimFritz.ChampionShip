<?php
namespace AchimFritz\ChampionShip\Import\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip.Import".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * A Simple Tip
 */
class Tip {

   /**
    * @var string 
    * @Flow\Validate(type="NotEmpty")
    */
   protected $cupName;

	/**
	 * The username
	 * @var string
    * @Flow\Validate(type="NotEmpty")
	 */
	protected $username;

	/**
	 * The email
	 * @var string
    * @Flow\Validate(type="NotEmpty")
    * @Flow\Validate(type="EmailAddress")
	 */
	protected $email;

	/**
	 * The home tip
	 * @var integer
	 */
	protected $homeTip;

	/**
	 * The guest tip
	 * @var integer
	 */
	protected $guestTip;

	/**
	 * @var string
	 */
	protected $homeTeam;

	/**
	 * @var string
	 */
	protected $guestTeam;

	/**
	 * The group name
	 * @var string
	 */
	protected $groupName;

	/**
	 * The round type
	 * @var integer
	 */
	protected $roundType;


	/**
	 * Get the Wm two six's username
	 *
	 * @return string The Wm two six's username
	 */
	public function getUsername() {
		if (isset($this->username)) {
			return $this->username;
		}
		return $this->getEmail();
	}

	/**
	 * Sets this Wm two six's username
	 *
	 * @param string $username The Wm two six's username
	 * @return void
	 */
	public function setUsername($username) {
		$this->username = $username;
	}

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
	 * Get the Wm two six's email
	 *
	 * @return string The Wm two six's email
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * Sets this Wm two six's email
	 *
	 * @param string $email The Wm two six's email
	 * @return void
	 */
	public function setEmail($email) {
		$this->email = $email;
	}

	/**
	 * Get the Wm two six's home tip
	 *
	 * @return integer The Wm two six's home tip
	 */
	public function getHomeTip() {
		return $this->homeTip;
	}

	/**
	 * Sets this Wm two six's home tip
	 *
	 * @param integer $homeTip The Wm two six's home tip
	 * @return void
	 */
	public function setHomeTip($homeTip) {
		$this->homeTip = $homeTip;
	}

	/**
	 * Get the Wm two six's guest tip
	 *
	 * @return integer The Wm two six's guest tip
	 */
	public function getGuestTip() {
		return $this->guestTip;
	}

	/**
	 * Sets this Wm two six's guest tip
	 *
	 * @param integer $guestTip The Wm two six's guest tip
	 * @return void
	 */
	public function setGuestTip($guestTip) {
		$this->guestTip = $guestTip;
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

}
?>
