<?php
namespace AchimFritz\ChampionShip\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * A Ranking
 *
 * @Flow\Entity
 */
class Ranking {
	
	/**
	 * The user
	 * @var \AchimFritz\ChampionShip\Domain\Model\User
	 * @Flow\Validate(type="NotEmpty")
	 * @ORM\ManyToOne
	 */
	protected $user;

	/**
	 * The points
	 * @var integer
	 */
	protected $points;

	/**
	 * @var integer
	 */
	protected $rank;
	
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
	 * Get the Rank's rank
	 *
	 * @return integer The Rank's rank
	 */
	public function getRank() {
		return $this->rank;
	}

	/**
	 * Sets this Rank's rank
	 *
	 * @param integer $rank The Rank's rank
	 * @return void
	 */
	public function setRank($rank) {
		$this->rank = $rank;
	}

}
?>
