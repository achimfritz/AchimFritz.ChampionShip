<?php
namespace AchimFritz\ChampionShip\User\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;
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
	 */
	protected $account;

	/**
	 * @var \Doctrine\Common\Collections\Collection<\AchimFritz\ChampionShip\Tip\Domain\Model\Tip>
	 * @ORM\OneToMany(mappedBy="user", cascade={"all"})
	 */
	protected $tips;

	/**
	 * @var \Doctrine\Common\Collections\Collection<\AchimFritz\ChampionShip\Tip\Domain\Model\Ranking>
	 * @ORM\OneToMany(mappedBy="user", cascade={"all"})
	 */
	protected $rankings;

	/**
	 * @var \Doctrine\Common\Collections\Collection<\AchimFritz\ChampionShip\Chat\Domain\Model\ChatEntry>
	 * @ORM\OneToMany(mappedBy="user", cascade={"all"})
	 */
	protected $chatEntries;


	/**
	 * @var string
	 * @Flow\Validate(type="NotEmpty")
	 * @Flow\Validate(type="EmailAddress")
	 */
	protected $email;

	/**
	 * @var \Doctrine\Common\Collections\Collection<\AchimFritz\ChampionShip\User\Domain\Model\TipGroup>
	 * @ORM\ManyToMany
	 */
	protected $tipGroups;

	/**
	 * @var \AchimFritz\ChampionShip\User\Domain\Model\TipGroup
	 * @ORM\ManyToOne
	 */
	protected $tipGroup;

   /**
    * __construct 
    * 
    * @return void
    */
   public function __construct() {
      $this->tipGroups = new \Doctrine\Common\Collections\ArrayCollection();
   }

	/**
	 * getTipGroup
	 *
	 * @return TipGroup
	 */
	public function getTipGroup() {
		return $this->tipGroup;
	}

	/**
	 * setTipGroup
	 *
	 * @param TipGroup $tipGroup
	 * @return void
	 */
	public function setTipGroup(TipGroup $tipGroup) {
		$this->tipGroup = $tipGroup;
		$this->addTipGroup($tipGroup);
	}

	/**
	 * getTipGroups
	 *
	 * @return  The Cup's tipGroups
	 */
	public function getTipGroups() {
		return $this->tipGroups;
	}

	/**
	 * setTipGroups
	 *
	 * @param  $tipGroups The Cup's tipGroups
	 * @return void
	 */
	public function setTipGroups($tipGroups) {
		$this->tipGroups = $tipGroups;
	}

	/**
	 * removeTipGroup 
	 * 
	 * @param TipGroup $tipGroup 
	 * @return void
	 */
	public function removeTipGroup(TipGroup $tipGroup) {
		$this->tipGroups->removeElement($tipGroup);
	}

	/**
	 * hasTipGroup 
	 * 
	 * @param TipGroup $tipGroup 
	 * @return void
	 */
	public function hasTipGroup(TipGroup $tipGroup) {
		return $this->tipGroups->contains($tipGroup);
	}

	/**
	 * addTipGroup 
	 * 
	 * @param TipGroup $tipGroup 
	 * @return void
	 */
	public function addTipGroup(TipGroup $tipGroup) {
		if ($this->hasTipGroup($tipGroup) === FALSE) {
			$this->tipGroups->add($tipGroup);
		}
	}

	/**
	 * getEmail 
	 * 
	 * @return string
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * setEmail 
	 * 
	 * @param string $email 
	 * @return void
	 */
	public function setEmail($email) {
		$this->email = $email;
	}

	/**
	 * getName 
	 * 
	 * @return string
	 */
	public function getUsername() {
		return $this->getAccount()->getAccountIdentifier();
	}

	/**
	 * getName 
	 * 
	 * @return string
	 */
	public function getName() {
		return $this->getAccount()->getAccountIdentifier();
	}

	/**
	 * getDisplayName 
	 * 
	 * @return string
	 */
	public function getDisplayName() {
		$tipGroup = $this->getTipGroup();
		if ($tipGroup instanceof TipGroup) {
			return $this->getAccount()->getAccountIdentifier() . '@' . $tipGroup->getName();
		} else {
			return $this->getAccount()->getAccountIdentifier();
		}
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

	/**
	 * getAccount 
	 * 
	 * @return Account
	 */
	public function getAccount() {
		return $this->account;
	}

	/**
	 * getTips 
	 * 
	 * @return \Doctrine\Common\Collections\Collection<\AchimFritz\ChampionShip\Tip\Domain\Model\Tip>
	 */
	public function getTips() {
		return $this->tips;
	}

}
?>
