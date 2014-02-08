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
class User extends Account {

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
	 * @var string
	 * @Flow\Validate(type="NotEmpty")
	 * @Flow\Validate(type="EmailAddress")
	 */
	protected $email;

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

}
?>
