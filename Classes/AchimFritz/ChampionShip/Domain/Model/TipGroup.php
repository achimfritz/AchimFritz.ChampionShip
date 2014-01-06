<?php
namespace AchimFritz\ChampionShip\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;
use AchimFritz\ChampionShip\Domain\Model\User;

/**
 * A TipGroup
 *
 * @Flow\Entity
 */
class TipGroup {
	
	/**
	 * The name
	 * @var string
	 * @Flow\Identity
	 * @Flow\Validate(type="NotEmpty")
	 */
	protected $name;

	/**
	 * @var \Doctrine\Common\Collections\Collection<\AchimFritz\ChampionShip\Domain\Model\User>
	 * @ORM\ManyToMany
	 */
	protected $users;

   /**
    * __construct 
    * 
    * @return void
    */
   public function __construct() {
      $this->users = new \Doctrine\Common\Collections\ArrayCollection();
   }

	/**
	 * getUsers
	 *
	 * @return  The Cup's users
	 */
	public function getUsers() {
		return $this->users;
	}

	/**
	 * setUsers
	 *
	 * @param  $users The Cup's users
	 * @return void
	 */
	public function setUsers($users) {
		$this->users = $users;
	}

	/**
	 * removeUser 
	 * 
	 * @param User $user 
	 * @return void
	 */
	public function removeUser(User $user) {
		$this->users->removeElement($user);
	}

	/**
	 * addUser 
	 * 
	 * @param User $user 
	 * @return void
	 */
	public function addUser(User $user) {
		$this->users->add($user);
	}

	/**
	 * getName
	 *
	 * @return string 
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * setName
	 *
	 * @param string $name
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
	}
}
?>
