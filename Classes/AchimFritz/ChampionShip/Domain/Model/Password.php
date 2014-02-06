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
	 * @var \TYPO3\Flow\Security\Account
	 * @ORM\OneToOne
	 * @Flow\Validate(type="NotEmpty")
	 */
	protected $account;

	/**
	 * @return string
	 */
	public function getOldPassword() {
		return $this->oldPassword;
	}

	/**
	 * @param string $oldPassword
	 * @return void
	 */
	public function setOldPassword($oldPassword) {
		$this->oldPassword = $oldPassword;
	}

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
	 * getAccount 
	 * 
	 * @return Account account
	 */
	public function getAccount() {
		return $this->account;
	}

	/**
	 * setAccount
	 * 
	 * @param Account $account
	 * @return void
	 */
	public function setAccount(Account $account) {
		$this->account = $account;
	} 


}
?>
