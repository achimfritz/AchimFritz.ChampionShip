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
class ContactRequest
{

    /**
     * @var string
     * @Flow\Validate(type="NotEmpty")
     * @Flow\Validate(type="EmailAddress")
     */
    protected $email;

    /**
     * @var string
     * @Flow\Validate(type="NotEmpty")
     */
    protected $subject;

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
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     * @return void
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
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
