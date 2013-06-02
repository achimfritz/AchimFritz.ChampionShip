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
	 * The name
	 * @var string
	 * @Flow\Identity
     * @Flow\Validate(type="NotEmpty")
	 */
	protected $name;


	/**
	 * Get the User's name
	 *
	 * @return string The User's name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Sets this User's name
	 *
	 * @param string $name The User's name
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
	}

}
?>