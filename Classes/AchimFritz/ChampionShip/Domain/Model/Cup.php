<?php
namespace AchimFritz\ChampionShip\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;
use AchimFritz\ChampionShip\Domain\Model\Team;

/**
 * A Cup
 *
 * @Flow\Entity
 */
class Cup {
	
	/**
	 * The name
	 * @var string
	 * @Flow\Identity
	 * @Flow\Validate(type="NotEmpty")
	 */
	protected $name;

	/**
	 * The teams
	 * @var \Doctrine\Common\Collections\Collection<\AchimFritz\ChampionShip\Domain\Model\Team>
	 * @ORM\ManyToMany
	 */
	protected $teams;

	/**
	 * @var \Doctrine\Common\Collections\Collection<\AchimFritz\ChampionShip\Domain\Model\Ranking>
	 * @ORM\OneToMany(mappedBy="cup", cascade={"all"})
	 */
	protected $rankings;

	/**
	 * @var \Doctrine\Common\Collections\Collection<\AchimFritz\ChampionShip\Domain\Model\Round>
	 * @ORM\OneToMany(mappedBy="cup", cascade={"all"})
	 */
	protected $rounds;

	/**
	 * The start date
	 * @var \DateTime
	 * @Flow\Validate(type="NotEmpty")
	 */
	protected $startDate;
   
   /**
    * __construct 
    * 
    * @return void
    */
   public function __construct() {
      $this->teams = new \Doctrine\Common\Collections\ArrayCollection();
   }
	
	/**
	 * Get the Team's name
	 *
	 * @return string The Team's name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Sets this Team's name
	 *
	 * @param string $name The Team's name
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
	}


	/**
	 * Get the Cup's teams
	 *
	 * @return  The Cup's teams
	 */
	public function getTeams() {
		return $this->teams;
	}

	/**
	 * Sets this Cup's teams
	 *
	 * @param  $teams The Cup's teams
	 * @return void
	 */
	public function setTeams($teams) {
		$this->teams = $teams;
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

	/**
	 * hasTeam 
	 * 
	 * @param Team $team 
	 * @return boolean
	 */
	public function hasTeam(Team $team) {
		return $this->teams->contains($team);
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

}
?>
