<?php
namespace AchimFritz\ChampionShip\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * A User
 *
 * @Flow\Entity
 */
class User {

	/**
	 * @var \TYPO3\Flow\Security\Account
	 * @ORM\OneToOne
	 * @Flow\Validate(type="NotEmpty")
	 */
	protected $account;

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
	public function setAccount($account) {
		$this->account = $account;
	} 
}
?>
