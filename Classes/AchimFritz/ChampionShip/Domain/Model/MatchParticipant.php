<?php
namespace AchimFritz\ChampionShip\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * A Match participant
 *
 * @Flow\Entity
 */
class MatchParticipant {

	/**
	 * The team
	 * @var \AchimFritz\ChampionShip\Domain\Model\Team
	 * @ORM\ManyToOne
	 */
	protected $team;

	/**
	 * The winner of match
	 * @var \AchimFritz\ChampionShip\Domain\Model\Match
	 * @ORM\OneToOne
	 */
	protected $winnerOfMatch;

	/**
	 * The looser of match
	 * @var \AchimFritz\ChampionShip\Domain\Model\Match
	 * @ORM\OneToOne
	 */
	protected $looserOfMatch;

	/**
	 * The group round
	 * @var \AchimFritz\ChampionShip\Domain\Model\GroupRound
	 * @ORM\ManyToOne
	 */
	protected $groupRound;

	/**
	 * The rank of group round
	 * @var integer
	 */
	protected $rankOfGroupRound = 0;


	/**
	 * Get the Match participant's team
	 *
	 * @return \AchimFritz\ChampionShip\Domain\Model\Team The Match participant's team
	 */
	public function getTeam() {
		return $this->team;
	}

	/**
	 * Sets this Match participant's team
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\Team $team The Match participant's team
	 * @return void
	 */
	public function setTeam(\AchimFritz\ChampionShip\Domain\Model\Team $team) {
		$this->team = $team;
	}

	/**
	 * Get the Match participant's name
	 *
	 * @return string The Match participant's name
	 */
	public function getName() {
		if (isset($this->team)) {
			return $this->team->getName();
		} elseif (isset($this->groupRound)) {
			return $this->rankOfGroupRound . '. ' . $this->groupRound->getName();
		} elseif (isset($this->winnerOfMatch)) {
			return 'winner ' . $this->winnerOfMatch->getName();
		} elseif (isset($this->looserOfMatch)) {
			return 'looser ' . $this->looserOfMatch->getName();
		} else {
			return '';
		}
	}


	/**
	 * Get the Match participant's winner of match
	 *
	 * @return \AchimFritz\ChampionShip\Domain\Model\Match The Match participant's winner of match
	 */
	public function getWinnerOfMatch() {
		return $this->winnerOfMatch;
	}

	/**
	 * Sets this Match participant's winner of match
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\Match $winnerOfMatch The Match participant's winner of match
	 * @return void
	 */
	public function setWinnerOfMatch(\AchimFritz\ChampionShip\Domain\Model\Match $winnerOfMatch) {
		$this->winnerOfMatch = $winnerOfMatch;
	}

	/**
	 * Get the Match participant's looser of match
	 *
	 * @return \AchimFritz\ChampionShip\Domain\Model\Match The Match participant's looser of match
	 */
	public function getLooserOfMatch() {
		return $this->looserOfMatch;
	}

	/**
	 * Sets this Match participant's looser of match
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\Match $looserOfMatch The Match participant's looser of match
	 * @return void
	 */
	public function setLooserOfMatch(\AchimFritz\ChampionShip\Domain\Model\Match $looserOfMatch) {
		$this->looserOfMatch = $looserOfMatch;
	}

	/**
	 * Get the Match participant's group round
	 *
	 * @return \AchimFritz\ChampionShip\Domain\Model\GroupRound The Match participant's group round
	 */
	public function getGroupRound() {
		return $this->groupRound;
	}

	/**
	 * Sets this Match participant's group round
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\GroupRound $groupRound The Match participant's group round
	 * @return void
	 */
	public function setGroupRound(\AchimFritz\ChampionShip\Domain\Model\GroupRound $groupRound) {
		$this->groupRound = $groupRound;
	}

	/**
	 * Get the Match participant's rank of group round
	 *
	 * @return integer The Match participant's rank of group round
	 */
	public function getRankOfGroupRound() {
		return $this->rankOfGroupRound;
	}

	/**
	 * Sets this Match participant's rank of group round
	 *
	 * @param integer $rankOfGroupRound The Match participant's rank of group round
	 * @return void
	 */
	public function setRankOfGroupRound($rankOfGroupRound) {
		$this->rankOfGroupRound = $rankOfGroupRound;
	}

}
?>