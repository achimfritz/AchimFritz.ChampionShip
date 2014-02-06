<?php
namespace AchimFritz\ChampionShip\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;
use AchimFritz\ChampionShip\Domain\Model\TipGroup;
use TYPO3\Flow\Security\Account;

/**
 * A User
 *
 * @Flow\Entity
 */
class User {

	/**
	 * @var \TYPO3\Flow\Security\Account
	 * @ORM\OneToOne(cascade={"all"})
	 * @Flow\Validate(type="NotEmpty")
	 */
	protected $account;

	/**
	 * @var \Doctrine\Common\Collections\Collection<\AchimFritz\ChampionShip\Domain\Model\Tip>
	 * @ORM\OneToMany(mappedBy="user", cascade={"all"})
	 */
	protected $tips;

	/**
	 * @var \Doctrine\Common\Collections\Collection<\AchimFritz\ChampionShip\Domain\Model\Ranking>
	 * @ORM\OneToMany(mappedBy="user", cascade={"all"})
	 */
	protected $rankings;

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

	/**
	 * getName 
	 * 
	 * @return string
	 */
	public function getName() {
		return $this->getAccount()->getParty()->getName()->getOtherName();
	}

}
?>
