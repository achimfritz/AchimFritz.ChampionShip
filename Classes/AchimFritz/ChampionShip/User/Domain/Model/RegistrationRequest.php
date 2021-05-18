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
class RegistrationRequest
{

    /**
     * @var string
     * @Flow\Validate(type="NotEmpty")
     * @Flow\Validate(type="StringLength", options={ "minimum"=6, "maximum"=100 })
     */
    protected $newPassword;

    /**
     * @var string
     */
    protected $newPasswordRepeat;

    /**
     * @var \DateTime
     */
    protected $creationDate;

    /**
     * @var string
     * @Flow\Validate(type="NotEmpty")
     */
    protected $tipGroupName;

    /**
     * @var string
     * @Flow\Validate(type="NotEmpty")
     * @Flow\Validate(type="EmailAddress")
     */
    protected $email = '';

    /**
     * @var string
     * @Flow\Validate(type="NotEmpty")
     * @Flow\Validate(type="StringLength", options={ "minimum"=3, "maximum"=50 })
     */
    protected $username = '';

    /**
     * @return void
     */
    public function __construct()
    {
        $this->creationDate = new \DateTime();
    }

    /**
     * @return string
     */
    public function getNewPassword()
    {
        return $this->newPassword;
    }

    /**
     * @param string $newPassword
     * @return void
     */
    public function setNewPassword($newPassword)
    {
        $this->newPassword = $newPassword;
    }

    /**
     * @return string
     */
    public function getNewPasswordRepeat()
    {
        return $this->newPasswordRepeat;
    }

    /**
     * @param string $newPasswordRepeat
     * @return void
     */
    public function setNewPasswordRepeat($newPasswordRepeat)
    {
        $this->newPasswordRepeat = $newPasswordRepeat;
    }

    /**
     * @return string tipGroupName
     */
    public function getTipGroupName()
    {
        return $this->tipGroupName;
    }

    /**
     * @param string $tipGroupName
     * @return void
     */
    public function setTipGroupName($tipGroupName)
    {
        $this->tipGroupName = $tipGroupName;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return void
     */
    public function setUsername($username)
    {
        $this->username = $username;
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
