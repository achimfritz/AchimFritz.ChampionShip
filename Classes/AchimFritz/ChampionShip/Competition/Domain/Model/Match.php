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
 * @ORM\InheritanceType("JOINED")
 */
class Match
{

    /**
     * @var \AchimFritz\ChampionShip\Competition\Domain\Model\Team
     * @ORM\ManyToOne
     */
    protected $hostTeam;

    /**
     * @var \AchimFritz\ChampionShip\Competition\Domain\Model\Team
     * @ORM\ManyToOne
     */
    protected $guestTeam;

    /**
     * The cup
     * @var \AchimFritz\ChampionShip\Competition\Domain\Model\Cup
     * @ORM\ManyToOne
     * @Flow\Validate(type="NotEmpty")
     */
    protected $cup;
    
    /**
     * @var \AchimFritz\ChampionShip\Competition\Domain\Model\Round
     * @ORM\ManyToOne
     * @Flow\Validate(type="NotEmpty")
     */
    protected $round;
    
    /**
     * The result
     * @var \AchimFritz\ChampionShip\Competition\Domain\Model\Result
     * @ORM\OneToOne
     */
    protected $result = null;

    /**
     * The start date
     * @var \DateTime
     * @Flow\Validate(type="NotEmpty")
     */
    protected $startDate;

    /**
     * @var string
     */
    protected $name = '';

    /**
     * @param Cup $cup
     * @param Round $round
     * @param Team $hostTeam
     * @param Team $guestTeam
     * @return void
     */
    public function __construct(Cup $cup = null, Round $round = null, Team $hostTeam =  null, Team $guestTeam = null)
    {
        if ($cup !== null) {
            $this->setCup($cup);
            $this->setStartDate($cup->getStartDate());
        } else {
            $this->setStartDate(new \DateTime());
        }
        if ($round !== null) {
            $this->setRound($round);
        }
        if ($hostTeam !== null && $guestTeam !== null) {
            $this->setHostTeam($hostTeam);
            $this->setGuestTeam($guestTeam);
        }
    }



    /**
     * getLooserTeam
     *
     * @return Team|NULL
     */
    public function getLooserTeam()
    {
        $result = $this->getResult();
        if ($result instanceof Result) {
            if ($result->getHostTeamGoals() < $result->getGuestTeamGoals()) {
                if ($this->getHostTeam() instanceof Team) {
                    return $this->getHostTeam();
                }
            }
            if ($result->getHostTeamGoals() > $result->getGuestTeamGoals()) {
                if ($this->getGuestTeam() instanceof Team) {
                    return $this->getGuestTeam();
                }
            }
        }
        return null;
    }
    
    /**
     * getWinnerTeam
     *
     * @return Team|NULL
     */
    public function getWinnerTeam()
    {
        $result = $this->getResult();
        if ($result instanceof Result) {
            if ($result->getHostTeamGoals() > $result->getGuestTeamGoals()) {
                if ($this->getHostTeam() instanceof Team) {
                    return $this->getHostTeam();
                }
            }
            if ($result->getHostTeamGoals() < $result->getGuestTeamGoals()) {
                if ($this->getGuestTeam() instanceof Team) {
                    return $this->getGuestTeam();
                }
            }
        }
        return null;
    }

    /**
     * getTeamHasWonThisMatch
     *
     * @param Team $team
     * @return boolean
     */
    public function getTeamHasWonThisMatch(Team $team)
    {
        $winner = $this->getWinnerTeam();
        if ($winner instanceof Team and $winner === $team) {
            return true;
        }
        return false;
    }
    
    /**
     * twoTeamsPlayThisMatch
     *
     * @param \AchimFritz\ChampionShip\Competition\Domain\Model\Team
     * @param \AchimFritz\ChampionShip\Competition\Domain\Model\Team
     * @return boolean
     */
    public function getTwoTeamsPlayThisMatch(Team $teamOne, Team $teamTwo)
    {
        $hostTeam = $this->getHostTeam();
        $guestTeam = $this->getGuestTeam();
        if (!isset($hostTeam) or !isset($guestTeam)) {
            return false;
        }
        if (
                ($hostTeam === $teamOne and
                 $guestTeam === $teamTwo) or
                ($hostTeam === $teamTwo and
                 $guestTeam === $teamOne)) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * getName
     *
     * @return string name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * setName
     *
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    
    /**
     * Get the Match's round
     *
     * @return \AchimFritz\ChampionShip\Competition\Domain\Model\Round The Match's round
     */
    public function getRound()
    {
        return $this->round;
    }

    /**
     * Sets this Match's round
     *
     * @param \AchimFritz\ChampionShip\Competition\Domain\Model\Round $round The Match's round
     * @return void
     */
    public function setRound(Round $round)
    {
        $this->round = $round;
    }
    
    
    /**
     * Get the Match's cup
     *
     * @return \AchimFritz\ChampionShip\Competition\Domain\Model\Cup The Match's cup
     */
    public function getCup()
    {
        return $this->cup;
    }

    /**
     * Sets this Match's cup
     *
     * @param \AchimFritz\ChampionShip\Competition\Domain\Model\Cup $cup The Match's cup
     * @return void
     */
    public function setCup(Cup $cup)
    {
        $this->cup = $cup;
    }

    /**
     * Get the Match's result
     *
     * @return \AchimFritz\ChampionShip\Competition\Domain\Model\Result The Match's result
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Sets this Match's result
     *
     * @param \AchimFritz\ChampionShip\Competition\Domain\Model\Result $result The Match's result
     * @return void
     */
    public function setResult(Result $result)
    {
        $this->result = $result;
    }

    /**
     * Get the Match's start date
     *
     * @return \DateTime The Match's start date
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Sets this Match's start date
     *
     * @param \DateTime $startDate The Match's start date
     * @return void
     */
    public function setStartDate(\DateTime $startDate)
    {
        $this->startDate = $startDate;
    }
    
    /**
     * Get the Match hostTeam
     *
     * @return \AchimFritz\ChampionShip\Competition\Domain\Model\Team
     */
    public function getHostTeam()
    {
        return $this->hostTeam;
    }

    /**
     * Sets this Match host team
     *
     * @param \AchimFritz\ChampionShip\Competition\Domain\Model\Team $team
     * @return void
     */
    public function setHostTeam(Team $hostTeam)
    {
        $this->hostTeam = $hostTeam;
    }
    
    /**
     * Get the Match guestTeam
     *
     * @return \AchimFritz\ChampionShip\Competition\Domain\Model\Team
     */
    public function getGuestTeam()
    {
        return $this->guestTeam;
    }

    /**
     * Sets this Match guest team
     *
     * @param \AchimFritz\ChampionShip\Competition\Domain\Model\Team $team
     * @return void
     */
    public function setGuestTeam(Team $guestTeam)
    {
        $this->guestTeam = $guestTeam;
    }

    /**
     * @return bool
     */
    public function isPlayedAndNotRemis()
    {
        return $this->getResult() !== null && $this->getResult()->getIsRemis() === false;
    }
}
