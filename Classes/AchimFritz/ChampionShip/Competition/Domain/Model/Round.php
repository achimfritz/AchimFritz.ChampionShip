<?php
namespace AchimFritz\ChampionShip\Competition\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *  a                                                                      */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * A Round
 *
 * @Flow\Entity
 * @ORM\InheritanceType("JOINED")
 */
class Round {

	/**
	 * The name
	 * @var string
	 * @Flow\Validate(type="NotEmpty")
	 */
	protected $name;

	/**
	 * The teams
	 * @var \Doctrine\Common\Collections\Collection<\AchimFritz\ChampionShip\Competition\Domain\Model\Team>
	 * @ORM\ManyToMany
	 */
	protected $teams;
	
	/**
	 * @var \Doctrine\Common\Collections\Collection<\AchimFritz\ChampionShip\Competition\Domain\Model\Match>
	 * @ORM\OneToMany(mappedBy="round", cascade={"all"})
	 * @ORM\OrderBy({"startDate" = "ASC"})
	 */
	protected $generalMatches;

	/**
	 * The cup
	 * @var \AchimFritz\ChampionShip\Competition\Domain\Model\Cup
	 * @ORM\ManyToOne
	 * @Flow\Validate(type="NotEmpty")
	 */
	protected $cup;
	
	/**
	 * __construct
	 */
	public function __construct() {
		$this->teams = new \Doctrine\Common\Collections\ArrayCollection();
		$this->generalMatches = new \Doctrine\Common\Collections\ArrayCollection();
	}
		
	/**
	 * addGeneralMatch
	 * 
	 * @param \AchimFritz\ChampionShip\Competition\Domain\Model\Match
	 * @return void
	 */
	public function addGeneralMatch(Match $generalMatch) {
		$generalMatch->setRound($this);
		$this->generalMatches->add($generalMatch);
	}
	
	/**
	 * setGeneralMatches
	 * 
	 * @return \Doctrine\Common\Collections\Collection<\AchimFritz\ChampionShip\Competition\Domain\Model\Match>
	 */
	public function getGeneralMatches() {
		return $this->generalMatches;
	}

	/**
	 * Get the Round's name
	 *
	 * @return string The Round's name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Sets this Round's name
	 *
	 * @param string $name The Round's name
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * Get the Round's teams
	 *
	 * @return \Doctrine\Common\Collections\Collection<\AchimFritz\ChampionShip\Competition\Domain\Model\Team> The Round's teams
	 */
	public function getTeams() {
		return $this->teams;
	}

	/**
	 * Sets this Round's teams
	 *
	 * @param \Doctrine\Common\Collections\Collection<\AchimFritz\ChampionShip\Competition\Domain\Model\Team> $teams The Round's teams
	 * @return void
	 */
	public function setTeams(\Doctrine\Common\Collections\Collection $teams) {
		$this->teams = $teams;
	}

   /**
    * addTeam 
    * 
    * @param Team $team 
    * @return void
    */
   public function addTeam(Team $team) {
      $this->teams->add($team);
   }

   /**
    * hasTeam 
    * 
    * @param Team $team 
    * @return boolean
    */
   public function hasTeam(Team $team) {
      foreach ($this->teams AS $existingTeam) {
         if ($team === $existingTeam) {
            return TRUE;
         }
      }
      return FALSE;
   }


	/**
	 * Get the Round's cup
	 *
	 * @return \AchimFritz\ChampionShip\Competition\Domain\Model\Cup The Round's cup
	 */
	public function getCup() {
		return $this->cup;
	}

	/**
	 * Sets this Round's cup
	 *
	 * @param \AchimFritz\ChampionShip\Competition\Domain\Model\Cup $cup The Round's cup
	 * @return void
	 */
	public function setCup(\AchimFritz\ChampionShip\Competition\Domain\Model\Cup $cup) {
		$this->cup = $cup;
	}

}
?>
