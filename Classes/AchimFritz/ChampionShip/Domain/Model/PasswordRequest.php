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
 */
class PasswordRequest {

	/**
	 * @var string
	 */
	protected $username = '';

	/**
	 * @var string
	 */
	protected $email = '';

	/**
	 * @var string
	 */
	protected $hmac;

	/**
	 * @var \AchimFritz\ChampionShip\Domain\Model\User
	 * @ORM\OneToOne
	 */
	protected $user = NULL;


	/**
	 * @return string
	 */
	public function getUsername() {
		return $this->username;
	}

	/**
	 * @param string $username
	 * @return void
	 */
	public function setUsername($username) {
		$this->username = $username;
	}

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
	 * @return \AchimFritz\ChampionShip\Domain\Model\User
	 */
	public function getUser() {
		return $this->user;
	}

	/**
	 * @param \AchimFritz\ChampionShip\Domain\Model\User $user
	 * @return void
	 */
	public function setUser(User $user) {
		$this->user = $user;
	}

}
?>
