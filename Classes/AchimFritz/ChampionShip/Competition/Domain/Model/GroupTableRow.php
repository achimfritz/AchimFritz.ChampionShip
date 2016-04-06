<?php
namespace AchimFritz\ChampionShip\Competition\Domain\Model;

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
	 * @var \AchimFritz\ChampionShip\Competition\Domain\Model\Team
	 * @ORM\ManyToOne
	 */
	protected $team;
	
	/**
	 * @var \AchimFritz\ChampionShip\Competition\Domain\Model\GroupRound
	 * @ORM\ManyToOne
	 */
	protected $groupRound;

	/**
	 * @var integer
	 */
	protected $goalsPlus = 0;

	/**
	 * @var integer
	 */
	protected $goalsMinus = 0;

	/**
	 * @var integer
	 */
	protected $points = 0;

	/**
	 * @var integer
	 */
	protected $rank = 1;

	/**
	 * @var integer
	 */
	protected $countOfMatchesPlayed = 0;

	/**
	 * @var integer
	 */
	protected $countOfMatchesWon = 0;

	/**
	 * @var integer
	 */
	protected $countOfMatchesRemis = 0;

	/**
	 * @var integer
	 */
	protected $countOfMatchesLoosed = 0;

	
	/**
	 * setGroupRound
	 *
	 * @param \AchimFritz\ChampionShip\Competition\Domain\Model\GroupRound
	 * @return void
	 */
	public function setGroupRound(\AchimFritz\ChampionShip\Domain\Model\GroupRound $groupRound) {
		$this->groupRound = $groupRound;
	}

	/**
	 * Get the Group table row's team
	 *
	 * @param \AchimFritz\ChampionShip\Competition\Domain\Model\Team The Group table row's team
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
	 * @return \AchimFritz\ChampionShip\Competition\Domain\Model\GroupRound
	 */
	public function getGroupRound() {
		return $this->groupRound;
	}

	/**
	 * Get the Group table row's team
	 *
	 * @return \AchimFritz\ChampionShip\Competition\Domain\Model\Team The Group table row's team
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

   /**
    * getGoalsMinus 
    * 
    * @return integer goalsMinus
    */
   public function getGoalsMinus() {
      return $this->goalsMinus;
   }

   /**
    * setGoalsMinus
    * 
    * @param integer $goalsMinus
    * @return void
    */
   public function setGoalsMinus($goalsMinus) {
      $this->goalsMinus = $goalsMinus;
   } 

   /**
    * getCountOfMatchesPlayed 
    * 
    * @return integer countOfMatchesPlayed
    */
   public function getCountOfMatchesPlayed() {
      return $this->countOfMatchesPlayed;
   }

   /**
    * setCountOfMatchesPlayed
    * 
    * @param integer $countOfMatchesPlayed
    * @return void
    */
   public function setCountOfMatchesPlayed($countOfMatchesPlayed) {
      $this->countOfMatchesPlayed = $countOfMatchesPlayed;
   }

   /**
    * getGoalsDiff 
    * 
    * @return integer
    */
   public function getGoalsDiff() {
      return $this->goalsPlus - $this->goalsMinus;
   }

	/**
	 * getCountOfMatchesWon 
	 * 
	 * @return integer countOfMatchesWon
	 */
	public function getCountOfMatchesWon() {
		return $this->countOfMatchesWon;
	}

	/**
	 * setCountOfMatchesWon
	 * 
	 * @param integer $countOfMatchesWon
	 * @return void
	 */
	public function setCountOfMatchesWon($countOfMatchesWon) {
		$this->countOfMatchesWon = $countOfMatchesWon;
	}

	/**
	 * getCountOfMatchesLoosed 
	 * 
	 * @return integer countOfMatchesLoosed
	 */
	public function getCountOfMatchesLoosed() {
		return $this->countOfMatchesLoosed;
	}

	/**
	 * setCountOfMatchesLoosed
	 * 
	 * @param integer $countOfMatchesLoosed
	 * @return void
	 */
	public function setCountOfMatchesLoosed($countOfMatchesLoosed) {
		$this->countOfMatchesLoosed = $countOfMatchesLoosed;
	} 

	/**
	 * getCountOfMatchesRemis 
	 * 
	 * @return integer countOfMatchesRemis
	 */
	public function getCountOfMatchesRemis() {
		return $this->countOfMatchesRemis;
	}

	/**
	 * setCountOfMatchesRemis
	 * 
	 * @param integer $countOfMatchesRemis
	 * @return void
	 */
	public function setCountOfMatchesRemis($countOfMatchesRemis) {
		$this->countOfMatchesRemis = $countOfMatchesRemis;
	}
	

}
?>
