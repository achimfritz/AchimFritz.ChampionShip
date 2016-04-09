<?php
namespace AchimFritz\ChampionShip\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;
use TYPO3\Flow\Security\Account;

/**
 * @Flow\Entity
 */
class Password {

	/**
	 * @var string
	 * @Flow\Validate(type="NotEmpty")
	 * @Flow\Validate(type="StringLength", options={ "minimum"=6, "maximum"=50 })
	 */
	protected $newPassword;

	/**
	 * @var string
	 */
	protected $newPasswordRepeat;

	/**
	 * @var \AchimFritz\ChampionShip\Domain\Model\User
	 * @ORM\OneToOne
	 * @Flow\Validate(type="NotEmpty")
	 */
	protected $user;

	/**
	 * @return string
	 */
	public function getNewPassword() {
		return $this->newPassword;
	}

	/**
	 * @param string $newPassword
	 * @return void
	 */
	public function setNewPassword($newPassword) {
		$this->newPassword = $newPassword;
	}

	/**
	 * @return string
	 */
	public function getNewPasswordRepeat() {
		return $this->newPasswordRepeat;
	}

	/**
	 * @param string $newPasswordRepeat
	 * @return void
	 */
	public function setNewPasswordRepeat($newPasswordRepeat) {
		$this->newPasswordRepeat = $newPasswordRepeat;
	}

	/**
	 * getUser
	 * 
	 * @return User
	 */
	public function getUser() {
		return $this->user;
	}

	/**
	 * setUser
	 * 
	 * @param User $user
	 * @return void
	 */
	public function setUser(User $user) {
		$this->user = $user;
	} 


}
?>
