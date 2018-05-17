<?php
namespace AchimFritz\ChampionShip\Tip\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use AchimFritz\ChampionShip\Competition\Domain\Model\Cup;
use AchimFritz\ChampionShip\Competition\Domain\Model\Team;
use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Flow\Entity
 */
class TipCup
{
    const TIP_POINTS_TWO_ONE_POLICY = '\AchimFritz\ChampionShip\Tip\Domain\Policy\TipPoints\TwoOnePolicy';
    const TIP_POINTS_THREE_ONE_POLICY = '\AchimFritz\ChampionShip\Tip\Domain\Policy\TipPoints\ThreeOnePolicy';

    /**
     * @var \AchimFritz\ChampionShip\Competition\Domain\Model\Cup
     * @ORM\OneToOne(cascade={"persist"})
     */
    protected $cup;

    /**
     * @var string
     * @Flow\Validate(type="NotEmpty")
     */
    protected $tipPointsPolicy = self::TIP_POINTS_TWO_ONE_POLICY;

    /**
     * @return string tipPointsPolicy
     */
    public function getTipPointsPolicy()
    {
        return $this->tipPointsPolicy;
    }

    /**
     * @param string $tipPointsPolicy
     * @return void
     */
    public function setTipPointsPolicy($tipPointsPolicy)
    {
        $this->tipPointsPolicy = $tipPointsPolicy;
    }

    /**
     * @return Cup
     */
    public function getCup()
    {
        return $this->cup;
    }

    /**
     * @param Cup $cup
     */
    public function setCup($cup)
    {
        $this->cup = $cup;
    }

    /**
     * @return string
     */
    public function getGroupTablePolicy()
    {
        return $this->getCup()->getGroupTablePolicy();
    }

    /**
     * @return string The Team's name
     */
    public function getName()
    {
        return $this->getCup()->getName();
    }

    /**
     * @return  The Cup's teams
     */
    public function getTeams()
    {
        return $this->getCup()->getTeams();
    }

    /**
     * @return \DateTime The Match's start date
     */
    public function getStartDate()
    {
        return $this->getCup()->getStartDate();
    }

    /**
     * @param Team $team
     * @return boolean
     */
    public function hasTeam(Team $team)
    {
        return $this->getCup()->hasTeam($team);
    }
}
