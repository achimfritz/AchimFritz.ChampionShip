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
class RegistrationRequest extends AccountRequest {

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
	 * @var string
	 * @Flow\Validate(type="NotEmpty")
	 */
	protected $tipGroupName;

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
	 * getTipGroupName 
	 * 
	 * @return string tipGroupName
	 */
	public function getTipGroupName() {
		return $this->tipGroupName;
	}

	/**
	 * setTipGroupName
	 * 
	 * @param string $tipGroupName
	 * @return void
	 */
	public function setTipGroupName($tipGroupName) {
		$this->tipGroupName = $tipGroupName;
	} 

}
?>
