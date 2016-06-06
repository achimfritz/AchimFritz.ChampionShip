<?php
namespace AchimFritz\ChampionShip\Competition\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * A Match
 *
 * @Flow\Entity
 */
class CrossGroupMatch extends KoMatch {

	/**
	 * @var \AchimFritz\ChampionShip\Competition\Domain\Model\GroupRound
	 * @ORM\ManyToOne
	 * @Flow\Validate(type="NotEmpty")
	 */
	protected $hostGroupRound;

	/**
	 * @var integer
	 * @Flow\Validate(type="NotEmpty")
	 */
	protected $hostGroupRank;

	/**
	 * @var \AchimFritz\ChampionShip\Competition\Domain\Model\GroupRound
	 * @ORM\ManyToOne
	 * @Flow\Validate(type="NotEmpty")
	 */
	protected $guestGroupRound;

	/**
	 * @var integer
	 * @Flow\Validate(type="NotEmpty")
	 */
	protected $guestGroupRank;

	/**
	 * @return GroupRound hostGroupRound
	 */
	public function getHostGroupRound() {
		return $this->hostGroupRound;
	}

	/**
	 * @param GroupRound $hostGroupRound
	 * @return void
	 */
	public function setHostGroupRound(GroupRound $hostGroupRound) {
		$this->hostGroupRound = $hostGroupRound;
	}

	/**
	 * @return GroupRound guestGroupRound
	 */
	public function getGuestGroupRound() {
		return $this->guestGroupRound;
	}

	/**
	 * @param GroupRound $guestGroupRound
	 * @return void
	 */
	public function setGuestGroupRound(GroupRound $guestGroupRound) {
		$this->guestGroupRound = $guestGroupRound;
	}

	/**
	 * @param integer $hostGroupRank
	 * @return void
	 */
	public function setHostGroupRank($hostGroupRank) {
		$this->hostGroupRank = $hostGroupRank;
	}

	/**
	 * @return integer
	 */
	public function getHostGroupRank() {
		return $this->hostGroupRank;
	}

	/**
	 * @param integer $guestGroupRank
	 * @return void
	 */
	public function setGuestGroupRank($guestGroupRank) {
		$this->guestGroupRank = $guestGroupRank;
	}

	/**
	 * @return integer
	 */
	public function getGuestGroupRank() {
		return $this->guestGroupRank;
	}

	/**
	 * @return Team|NULL
	 */
	public function getCurrentHostTeam() {
		$groupRound = $this->getHostGroupRound();
		$rank = $this->getHostGroupRank();
		$team = $groupRound->getTeamByRank($rank);
		return $team;
	}

	/**
	 * @return Team|NULL
	 */
	public function getCurrentGuestTeam() {
		$groupRound = $this->getGuestGroupRound();
		if ($groupRound !== NULL) {
			$rank = $this->getGuestGroupRank();
			$team = $groupRound->getTeamByRank($rank);
			return $team;
		}
		return NULL;
	}

}
