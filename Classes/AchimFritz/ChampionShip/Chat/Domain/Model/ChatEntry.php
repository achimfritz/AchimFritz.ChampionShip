<?php
namespace AchimFritz\ChampionShip\Chat\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Flow\Entity
 * @ORM\InheritanceType("JOINED")
 */
class ChatEntry
{

    /**
     * @var \AchimFritz\ChampionShip\User\Domain\Model\User
     * @ORM\ManyToOne
     */
    protected $user;

    /**
     * @var string
     * @Flow\Validate(type="NotEmpty")
     */
    protected $message;

    /**
     * @var \DateTime
     */
    protected $creationDate;

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->creationDate = new \DateTime();
    }


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
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return void
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * @param \DateTime $creationDate
     * @return void
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    }
}
