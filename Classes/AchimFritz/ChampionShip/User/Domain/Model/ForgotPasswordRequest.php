<?php
namespace AchimFritz\ChampionShip\User\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use Neos\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Flow\Entity
 */
class ForgotPasswordRequest
{

    /**
     * @var \DateTime|NULL
     */
    protected $creationDate = null;

    /**
     * @var string
     * @Flow\Validate(type="EmailAddress")
     * @Flow\Validate(type="NotEmpty")
     */
    protected $email = '';

    /**
     * @var \AchimFritz\ChampionShip\User\Domain\Model\User
     * @ORM\ManyToOne
     */
    protected $user = null;

    /**
     * @var string
     */
    protected $hash = '';

    /**
     * @return void
     */
    public function __construct()
    {
        $this->creationDate = new \DateTime();
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @param string $hash
     */
    public function setHash($hash)
    {
        $this->hash = $hash;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return void
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @param \DateTime $creationDate
     * @return void
     */
    public function setCreationDate(\DateTime $creationDate)
    {
        $this->creationDate = $creationDate;
    }

    /**
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }
}
