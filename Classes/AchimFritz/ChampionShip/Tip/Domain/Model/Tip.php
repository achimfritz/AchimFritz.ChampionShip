<?php
namespace AchimFritz\ChampionShip\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * A Tip
 *
 * @Flow\Entity
 */
class Tip {

	/**
	 * The user
	 * @var \AchimFritz\ChampionShip\Domain\Model\User
	 * @ORM\ManyToOne
	 * @Flow\Validate(type="NotEmpty")
	 */
	protected $user;

	/**
	 * The match
	 * @var \AchimFritz\ChampionShip\Competition\Domain\Model\Match
	 * @ORM\ManyToOne
	 * @Flow\Validate(type="NotEmpty")
	 */
	protected $generalMatch;

	/**
	 * The restult
	 * @var \AchimFritz\ChampionShip\Competition\Domain\Model\Result
	 * @ORM\OneToOne
	 */
	protected $result;

	/**
	 * @var integer
	 */
	protected $points = 0;


	/**
	 * Get the Tip's user
	 *
	 * @return \AchimFritz\ChampionShip\Domain\Model\User The Tip's user
	 */
	public function getUser() {
		return $this->user;
	}

	/**
	 * Sets this Tip's user
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\User $user The Tip's user
	 * @return void
	 */
	public function setUser(\AchimFritz\ChampionShip\Domain\Model\User $user) {
		$this->user = $user;
	}

	/**
	 * Get the Points's match
	 *
	 * @return \AchimFritz\ChampionShip\Competition\Domain\Model\Match The Points's match
	 */
	public function getMatch() {
		return $this->generalMatch;
	}

	/**
	 * Sets this Points's match
	 *
	 * @param \AchimFritz\ChampionShip\Competition\Domain\Model\Match $abstractMatch The Points's match
	 * @return void
	 */
	public function setMatch(\AchimFritz\ChampionShip\Competition\Domain\Model\Match $match) {
		$this->generalMatch = $match;
	}

	/**
	 * Get the Tip's result
	 *
	 * @return \AchimFritz\ChampionShip\Competition\Domain\Model\Result The Tip's result
	 */
	public function getResult() {
		return $this->result;
	}

	/**
	 * Sets this Tip's restult
	 *
	 * @param \AchimFritz\ChampionShip\Competition\Domain\Model\Result $result The Tip's restult
	 * @return void
	 */
	public function setResult(\AchimFritz\ChampionShip\Competition\Domain\Model\Result $result) {
		$this->result = $result;
	}

	/**
	 * getPoints 
	 * 
	 * @return integer
	 */
	public function getPoints() {
		return $this->points;
	}

	/**
	 * setPoints 
	 * 
	 * @param integer $points 
	 * @return void
	 */
	public function setPoints($points) {
		$this->points = $points;
	}

}
?>
