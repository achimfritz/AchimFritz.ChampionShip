<?php
namespace AchimFritz\ChampionShip\Import\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip.Import".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 */
class User {

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var string
	 */
	protected $email;

	/**
	 * @var string
	 */
	protected $groups;


	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param string $name
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
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
	public function getGroups() {
		return $this->groups;
	}

	/**
	 * @param string $groups
	 * @return void
	 */
	public function setGroups($groups) {
		$this->groups = $groups;
	}

}
?>
