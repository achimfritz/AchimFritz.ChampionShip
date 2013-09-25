<?php
namespace AchimFritz\ChampionShip\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;
use AchimFritz\ChampionShip\Domain\Model\TipGroup;

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
	 * @var \AchimFritz\ChampionShip\Domain\Model\TipGroup
	 * @Flow\Validate(type="NotEmpty")
	 * @ORM\ManyToOne
	 */
	protected $mainTipGroup;

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

	/**
	 * getMainTipGroup 
	 * 
	 * @return TipGroup mainTipGroup
	 */
	public function getMainTipGroup() {
		return $this->mainTipGroup;
	}

	/**
	 * setMainTipGroup
	 * 
	 * @param TipGroup $mainTipGroup
	 * @return void
	 */
	public function setMainTipGroup($mainTipGroup) {
		$this->mainTipGroup = $mainTipGroup;
	} 
}
?>
