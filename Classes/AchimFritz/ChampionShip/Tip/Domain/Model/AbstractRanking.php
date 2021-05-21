<?php
namespace AchimFritz\ChampionShip\Tip\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use Neos\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * A Ranking
 */
abstract class AbstractRanking
{
    
    /**
     * @var \AchimFritz\ChampionShip\User\Domain\Model\User
     * @Flow\Validate(type="NotEmpty")
     * @ORM\ManyToOne
     */
    protected $user;

    /**
     * @var integer
     */
    protected $points = 0;

    /**
     * @var integer
     * @ORM\Column(name="ranking")
     */
    protected $rank = 0;

    /**
     * @var integer
     */
    protected $countOfTips = 0;
    
    /**
     * @return \AchimFritz\ChampionShip\User\Domain\Model\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param \AchimFritz\ChampionShip\User\Domain\Model\User $user
     * @return void
     */
    public function setUser(\AchimFritz\ChampionShip\User\Domain\Model\User $user)
    {
        $this->user = $user;
    }

    /**
     * @param integer $points
     * @return void
     */
    public function addPoints($points)
    {
        $this->setPoints($this->getPoints() + $points);
    }

    /**
     * @return void
     */
    public function increaseCountOfTips()
    {
        $this->setCountOfTips($this->getCountOfTips() + 1);
    }

    /**
     * @return void
     */
    public function addCountOfTips($countOfTips)
    {
        $this->setCountOfTips($this->getCountOfTips() + $countOfTips);
    }


    /**
     * @return integer
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * @param integer $points
     * @return void
     */
    public function setPoints($points)
    {
        $this->points = $points;
    }

    /**
     * @return integer
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * @param integer $rank
     * @return void
     */
    public function setRank($rank)
    {
        $this->rank = $rank;
    }

    /**
     * @return integer
     */
    public function getCountOfTips()
    {
        return $this->countOfTips;
    }

    /**
     * @param integer $countOfTips
     * @return void
     */
    public function setCountOfTips($countOfTips)
    {
        $this->countOfTips = $countOfTips;
    }
}
