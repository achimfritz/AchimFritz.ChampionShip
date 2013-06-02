<?php
namespace AchimFritz\ChampionShip\Domain\Model;

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
class Match {

	/**
	 * The host participant
	 * @var \AchimFritz\ChampionShip\Domain\Model\MatchParticipant
	 * @ORM\OneToOne
	 * @Flow\Validate(type="NotEmpty")
	 */
	protected $hostParticipant;

	/**
	 * The guest participant
	 * @var \AchimFritz\ChampionShip\Domain\Model\MatchParticipant
	 * @ORM\OneToOne
	 * @Flow\Validate(type="NotEmpty")
	 */
	protected $guestParticipant;
	
	/**
	 * The cup
	 * @var \AchimFritz\ChampionShip\Domain\Model\Cup
	 * @ORM\ManyToOne
	 * @Flow\Validate(type="NotEmpty")
	 */
	protected $cup;
	
	/**
	 * @var \AchimFritz\ChampionShip\Domain\Model\Round
	 * @ORM\ManyToOne
	 * @Flow\Validate(type="NotEmpty")
	 */
	protected $round;
	
	/**
	 * The result
	 * @var \AchimFritz\ChampionShip\Domain\Model\Result
	 * @ORM\OneToOne
	 */
	protected $result;

	/**
	 * The start date
	 * @var \DateTime
	 * @Flow\Validate(type="NotEmpty")
	 */
	protected $startDate;
	
	/**
	 * twoTeamsPlayThisMatch
	 * 
	 * @param \AchimFritz\ChampionShip\Domain\Model\Team
	 * @param \AchimFritz\ChampionShip\Domain\Model\Team
	 * @return boolean
	 */
	public function getTwoTeamsPlayThisMatch(\AchimFritz\ChampionShip\Domain\Model\Team $teamOne, \AchimFritz\ChampionShip\Domain\Model\Team $teamTwo) {
		$host = $this->getHostParticipant();
		$guest = $this->getGuestParticipant();
		if (!isset($host) OR !isset($guest)) {
			return FALSE;
		}
		return TRUE;
		if (
			($this->getHostParticipant()->getTeam() === $teamOne AND
			$this->getGuestParticipant()->getTeam() === $teamTwo) OR 
			($this->getHostParticipant()->getTeam() === $teamTwo AND
			$this->getGuestParticipant()->getTeam() === $teamOne)) {
				return TRUE;
		} else {
			return FALSE;
		}
	}


	/**
	 * Get the Match's host participant
	 *
	 * @return \AchimFritz\ChampionShip\Domain\Model\MatchParticipant The Match's host participant
	 */
	public function getHostParticipant() {
		return $this->hostParticipant;
	}

	/**
	 * Sets this Match's host participant
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\MatchParticipant $hostParticipant The Match's host participant
	 * @return void
	 */
	public function setHostParticipant(\AchimFritz\ChampionShip\Domain\Model\MatchParticipant $hostParticipant) {
		$this->hostParticipant = $hostParticipant;
	}

	/**
	 * Get the Match's guest participant
	 *
	 * @return \AchimFritz\ChampionShip\Domain\Model\MatchParticipant The Match's guest participant
	 */
	public function getGuestParticipant() {
		return $this->guestParticipant;
	}

	/**
	 * Sets this Match's guest participant
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\MatchParticipant $guestParticipant The Match's guest participant
	 * @return void
	 */
	public function setGuestParticipant(\AchimFritz\ChampionShip\Domain\Model\MatchParticipant $guestParticipant) {
		$this->guestParticipant = $guestParticipant;
	}
	
	/**
	 * Get the Match's round
	 *
	 * @return \AchimFritz\ChampionShip\Domain\Model\Round The Match's round
	 */
	public function getRound() {
		return $this->round;
	}

	/**
	 * Sets this Match's round
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\Round $round The Match's round
	 * @return void
	 */
	public function setRound($round) {
		$this->round = $round;
	}
	
	
	/**
	 * Get the Match's cup
	 *
	 * @return \AchimFritz\ChampionShip\Domain\Model\Cup The Match's cup
	 */
	public function getCup() {
		return $this->cup;
	}

	/**
	 * Sets this Match's cup
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\Cup $cup The Match's cup
	 * @return void
	 */
	public function setCup($cup) {
		$this->cup = $cup;
	}

	/**
	 * Get the Match's result
	 *
	 * @return \AchimFritz\ChampionShip\Domain\Model\Result The Match's result
	 */
	public function getResult() {
		return $this->result;
	}

	/**
	 * Sets this Match's result
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\Result $result The Match's result
	 * @return void
	 */
	public function setResult(\AchimFritz\ChampionShip\Domain\Model\Result $result) {
		$this->result = $result;
	}

	/**
	 * Get the Match's start date
	 *
	 * @return \DateTime The Match's start date
	 */
	public function getStartDate() {
		return $this->startDate;
	}

	/**
	 * Sets this Match's start date
	 *
	 * @param \DateTime $startDate The Match's start date
	 * @return void
	 */
	public function setStartDate(\DateTime $startDate) {
		$this->startDate = $startDate;
	}
	

}
?>