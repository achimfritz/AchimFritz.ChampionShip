<?php
namespace AchimFritz\ChampionShip\Competition\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Flow\Entity
 */
class ExtraPoint {

	/**
	 * @var \AchimFritz\ChampionShip\Competition\Domain\Model\Team
	 * @ORM\ManyToOne
	 * @Flow\Validate(type="NotEmpty")
	 */
	protected $team;

	/**
	 * @var \AchimFritz\ChampionShip\Competition\Domain\Model\Cup
	 * @ORM\ManyToOne
	 * @Flow\Validate(type="NotEmpty")
	 */
	protected $cup;

	/**
	 * @var integer
	 */
	protected $points;


	/**
	 * @return \AchimFritz\ChampionShip\Competition\Domain\Model\Team
	 */
	public function getTeam() {
		return $this->team;
	}

	/**
	 * @param \AchimFritz\ChampionShip\Competition\Domain\Model\Team $team
	 * @return void
	 */
	public function setTeam($team) {
		$this->team = $team;
	}

	/**
	 * @return \AchimFritz\ChampionShip\Competition\Domain\Model\Cup
	 */
	public function getCup() {
		return $this->cup;
	}

	/**
	 * @param \AchimFritz\ChampionShip\Competition\Domain\Model\Cup $cup
	 * @return void
	 */
	public function setCup($cup) {
		$this->cup = $cup;
	}

	/**
	 * @return integer
	 */
	public function getPoints() {
		return $this->points;
	}

	/**
	 * @param integer $points
	 * @return void
	 */
	public function setPoints($points) {
		$this->points = $points;
	}

}