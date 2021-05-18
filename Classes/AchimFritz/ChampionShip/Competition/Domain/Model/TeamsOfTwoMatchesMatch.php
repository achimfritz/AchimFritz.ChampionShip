<?php
namespace AchimFritz\ChampionShip\Competition\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use Neos\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;
use AchimFritz\ChampionShip\Competition\Domain\Model\KoMatch;

/**
 * A Match
 *
 * @Flow\Entity
 */
class TeamsOfTwoMatchesMatch extends KoMatch
{

    /**
     * @var \AchimFritz\ChampionShip\Competition\Domain\Model\KoMatch
     * @ORM\ManyToOne(cascade={"detach"})
     * @Flow\Validate(type="NotEmpty")
     */
    protected $hostMatch;

    /**
     * @var \AchimFritz\ChampionShip\Competition\Domain\Model\KoMatch
     * @ORM\ManyToOne(cascade={"detach"})
     * @Flow\Validate(type="NotEmpty")
     */
    protected $guestMatch;

    /**
     * @var boolean
     */
    protected $hostMatchIsWinner;

    /**
     * @var boolean
     */
    protected $guestMatchIsWinner;

    /**
     * @return KoMatch hostMatch
     */
    public function getHostMatch()
    {
        return $this->hostMatch;
    }

    /**
     * @param KoMatch $hostMatch
     * @return void
     */
    public function setHostMatch(KoMatch $hostMatch)
    {
        $this->hostMatch = $hostMatch;
    }

    /**
     * @return KoMatch guestMatch
     */
    public function getGuestMatch()
    {
        return $this->guestMatch;
    }

    /**
     * @param KoMatch $guestMatch
     * @return void
     */
    public function setGuestMatch(KoMatch $guestMatch)
    {
        $this->guestMatch = $guestMatch;
    }

    /**
     * @return boolean
     */
    public function getGuestMatchIsWinner()
    {
        return $this->guestMatchIsWinner;
    }

    /**
     * @param boolean $guestMatchIsWinner
     * @return void
     */
    public function setGuestMatchIsWinner($guestMatchIsWinner)
    {
        $this->guestMatchIsWinner = $guestMatchIsWinner;
    }

    /**
     * @return boolean
     */
    public function getHostMatchIsWinner()
    {
        return $this->hostMatchIsWinner;
    }

    /**
     * @param boolean $hostMatchIsWinner
     * @return void
     */
    public function setHostMatchIsWinner($hostMatchIsWinner)
    {
        $this->hostMatchIsWinner = $hostMatchIsWinner;
    }

    /**
     * @return Team|NULL
     */
    public function getCurrentHostTeam()
    {
        if ($this->getHostMatchIsWinner() === true) {
            return $this->getHostMatch()->getWinnerTeam();
        } else {
            return $this->getHostMatch()->getLooserTeam();
        }
    }

    /**
     * @return Team|NULL
     */
    public function getCurrentGuestTeam()
    {
        if ($this->getGuestMatchIsWinner() === true) {
            return $this->getGuestMatch()->getWinnerTeam();
        } else {
            return $this->getGuestMatch()->getLooserTeam();
        }
    }
}
