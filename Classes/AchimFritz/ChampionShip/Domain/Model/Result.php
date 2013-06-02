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

}
?>