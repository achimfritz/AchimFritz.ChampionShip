<?php
namespace AchimFritz\ChampionShip\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * A Points
 *
 * @Flow\Entity
 */
class Points {

	/**
	 * The cup
	 * @var \AchimFritz\ChampionShip\Domain\Model\Cup
	 * @ORM\ManyToOne
	 * @Flow\Validate(type="NotEmpty")
	 */
	protected $cup;
	
	/**
	 * The match
	 * @var \AchimFritz\ChampionShip\Domain\Model\Match
	 * @ORM\ManyToOne
	 * @Flow\Validate(type="NotEmpty")
	 */
	protected $generalMatch;

	/**
	 * The user
	 * @var \AchimFritz\ChampionShip\Domain\Model\User
	 * @ORM\ManyToOne
	 */
	protected $user;

	/**
	 * The points
	 * @var integer
	 */
	protected $points;

	/**
	 * The team
	 * @var \AchimFritz\ChampionShip\Domain\Model\Team
	 * @ORM\ManyToOne
	 */
	protected $team;


	/**
	 * Get the Points's cup
	 *
	 * @return \AchimFritz\ChampionShip\Domain\Model\Cup The Points's cup
	 */
	public function getCup() {
		return $this->cup;
	}

	/**
	 * Sets this Points's cup
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\Cup $cup The Points's cup
	 * @return void
	 */
	public function setCup(\AchimFritz\ChampionShip\Domain\Model\Cup $cup) {
		$this->cup = $cup;
	}
	
	/**
	 * Get the Points's match
	 *
	 * @return \AchimFritz\ChampionShip\Domain\Model\Match The Points's match
	 */
	public function getMatch() {
		return $this->generalMatch;
	}

	/**
	 * Sets this Points's match
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\Match $abstractMatch The Points's match
	 * @return void
	 */
	public function setMatch(\AchimFritz\ChampionShip\Domain\Model\Match $match) {
		$this->generalMatch = $match;
	}

	/**
	 * Get the Points's user
	 *
	 * @return \AchimFritz\ChampionShip\Domain\Model\User The Points's user
	 */
	public function getUser() {
		return $this->user;
	}

	/**
	 * Sets this Points's user
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\User $user The Points's user
	 * @return void
	 */
	public function setUser(\AchimFritz\ChampionShip\Domain\Model\User $user) {
		$this->user = $user;
	}


	/**
	 * Get the Points's points
	 *
	 * @return integer The Points's points
	 */
	public function getPoints() {
		return $this->points;
	}

	/**
	 * Sets this Points's points
	 *
	 * @param integer $points The Points's points
	 * @return void
	 */
	public function setPoints($points) {
		$this->points = $points;
	}

	/**
	 * Get the Points's team
	 *
	 * @return \AchimFritz\ChampionShip\Domain\Model\Team The Points's team
	 */
	public function getTeam() {
		return $this->team;
	}

	/**
	 * Sets this Points's team
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\Team $team The Points's team
	 * @return void
	 */
	public function setTeam(\AchimFritz\ChampionShip\Domain\Model\Team $team) {
		$this->team = $team;
	}

}
?>