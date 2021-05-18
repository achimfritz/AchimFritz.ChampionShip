<?php
namespace AchimFritz\ChampionShip\Competition\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use Neos\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * A Cup
 *
 * @Flow\Entity
 */
class Cup
{
    const GROUPTABLE_DEFAULT_POLICY = '\AchimFritz\ChampionShip\Competition\Domain\Policy\GroupTable\DefaultPolicy';
    const GROUPTABLE_FIFA_POINT_EQUALITY_POLICY = '\AchimFritz\ChampionShip\Competition\Domain\Policy\GroupTable\FifaPointEqualityPolicy';
    const GROUPTABLE_UEFA_POINT_EQUALITY_POLICY = '\AchimFritz\ChampionShip\Competition\Domain\Policy\GroupTable\UefaPointEqualityPolicy';

    /**
     * @var string
     * @Flow\Validate(type="NotEmpty")
     */
    protected $groupTablePolicy = self::GROUPTABLE_DEFAULT_POLICY;
    
    /**
     * @var string
     * @Flow\Identity
     * @Flow\Validate(type="NotEmpty")
     */
    protected $name;

    /**
     * @var \Doctrine\Common\Collections\Collection<\AchimFritz\ChampionShip\Competition\Domain\Model\Team>
     * @ORM\ManyToMany
     */
    protected $teams;

    /**
     * @var \Doctrine\Common\Collections\Collection<\AchimFritz\ChampionShip\Competition\Domain\Model\Round>
     * @ORM\OneToMany(mappedBy="cup", cascade={"all"})
     */
    protected $rounds;

    /**
     * @var \DateTime
     * @Flow\Validate(type="NotEmpty")
     */
    protected $startDate;
   
    /**
     * @return void
     */
    public function __construct()
    {
        $this->teams = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @param string
     * @return void
     */
    public function setGroupTablePolicy($groupTablePolicy)
    {
        $this->groupTablePolicy = $groupTablePolicy;
    }

    /**
     * @return string
     */
    public function getGroupTablePolicy()
    {
        return $this->groupTablePolicy;
    }
    
    /**
     * @return string The Team's name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name The Team's name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }


    /**
     * @return  The Cup's teams
     */
    public function getTeams()
    {
        return $this->teams;
    }

    /**
     * @param  $teams The Cup's teams
     * @return void
     */
    public function setTeams($teams)
    {
        $this->teams = $teams;
    }

    /**
     * @return \DateTime The Match's start date
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param \DateTime $startDate The Match's start date
     * @return void
     */
    public function setStartDate(\DateTime $startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     * @param Team $team
     * @return boolean
     */
    public function hasTeam(Team $team)
    {
        return $this->teams->contains($team);
    }

    /**
     * @param Team $team
     * @return void
     */
    public function addTeam(Team $team)
    {
        $this->teams->add($team);
    }
}
