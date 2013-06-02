<?php
namespace AchimFritz\ChampionShip\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * A Group table row
 *
 * @Flow\Entity
 */
class GroupTableRow {

	/**
	 * @var \AchimFritz\ChampionShip\Domain\Model\Team
	 * @ORM\ManyToOne
	 */
	protected $team;
	
	/**
	 * @var \AchimFritz\ChampionShip\Domain\Model\GroupRound
	 * @ORM\ManyToOne
	 */
	protected $groupRound;

	/**
	 * @var integer
	 */
	protected $goalsPlus;

	/**
	 * @var integer
	 */
	protected $points;

	/**
	 * @var integer
	 */
	protected $rank;
	

		#(inversedBy="groupTableRows")
		#Flow\ValueObject
		#$this->groupRound = $elements['groupRound'];
		
	
	/**
	 * setGroupRound
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\GroupRound
	 * @return void
	 */
	public function setGroupRound(\AchimFritz\ChampionShip\Domain\Model\GroupRound $groupRound) {
		$this->groupRound = $groupRound;
	}

	/**
	 * Get the Group table row's team
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\Team The Group table row's team
	 * @return void
	 */
	public function setTeam(\AchimFritz\ChampionShip\Domain\Model\Team $team) {
		$this->team = $team;
	}


	/**
	 * Get the Group table row's goals plus
	 *
	 * @param integer The Group table row's goals plus
	 * @return void
	 */
	public function setGoalsPlus($goalsPlus) {
		$this->goalsPlus = $goalsPlus;
	}


	/**
	 * Get the Group table row's points
	 *
	 * @param integer The Group table row's points
	 * @return void
	 */
	public function setPoints($points) {
		$this->points = $points;
	}

	/**
	 * Get the Group table row's rank
	 *
	 * @return integer The Group table row's rank
	 * @return void
	 */
	public function setRank($rank) {
		$this->rank = $rank;
	}

	
	/**
	 * getGroupRound
	 *
	 * @return \AchimFritz\ChampionShip\Domain\Model\GroupRound
	 */
	public function getGroupRound() {
		return $this->groupRound;
	}

	/**
	 * Get the Group table row's team
	 *
	 * @return \AchimFritz\ChampionShip\Domain\Model\Team The Group table row's team
	 */
	public function getTeam() {
		return $this->team;
	}


	/**
	 * Get the Group table row's goals plus
	 *
	 * @return integer The Group table row's goals plus
	 */
	public function getGoalsPlus() {
		return $this->goalsPlus;
	}


	/**
	 * Get the Group table row's points
	 *
	 * @return integer The Group table row's points
	 */
	public function getPoints() {
		return $this->points;
	}

	/**
	 * Get the Group table row's rank
	 *
	 * @return integer The Group table row's rank
	 */
	public function getRank() {
		return $this->rank;
	}


}
?>