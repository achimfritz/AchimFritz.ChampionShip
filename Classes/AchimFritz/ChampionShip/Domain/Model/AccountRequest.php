<?php
namespace AchimFritz\ChampionShip\Domain\Model;

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
class AccountRequest {

	/**
	 * @var string
	 * @Flow\Validate(type="NotEmpty")
	 * @Flow\Validate(type="EmailAddress")
	 */
	protected $email = '';

	/**
	 * @var string
	 */
	protected $hmac;


	/**
	 * @var \DateTime
	 */
	protected $creationDate;


	/**
	 * @return string
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * @param string $email
	 * @return void
	 */
	public function setEmail($email) {
		$this->email = $email;
	}

	/**
	 * @return string
	 */
	public function getHmac() {
		return $this->hmac;
	}

	/**
	 * @param string $hmac
	 * @return void
	 */
	public function setHmac($hmac) {
		$this->hmac = $hmac;
	}

	/**
	 * getCreationDate 
	 * 
	 * @return \DateTime creationDate
	 */
	public function getCreationDate() {
		return $this->creationDate;
	}

	/**
	 * setCreationDate
	 * 
	 * @param \DateTime $creationDate
	 * @return void
	 */
	public function setCreationDate($creationDate) {
		$this->creationDate = $creationDate;
	}

}
?>
