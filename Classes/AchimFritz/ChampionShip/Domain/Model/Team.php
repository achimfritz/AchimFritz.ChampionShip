<?php
namespace AchimFritz\ChampionShip\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * A Team
 *
 * @Flow\Entity
 */
class Team {

	/**
	 * The name
	 * @var string
	 * @Flow\Identity
     * @Flow\Validate(type="NotEmpty")
	 */
	protected $name;

	/**
	 * The short
	 * @var string
	 * @Flow\Validate(type="NotEmpty")
	 */
	protected $short;


	/**
	 * Get the Team's name
	 *
	 * @return string The Team's name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Sets this Team's name
	 *
	 * @param string $name The Team's name
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * Get the Team's short
	 *
	 * @return string The Team's short
	 */
	public function getShort() {
		return $this->short;
	}

	/**
	 * Sets this Team's short
	 *
	 * @param string $short The Team's short
	 * @return void
	 */
	public function setShort($short) {
		$this->short = $short;
	}

}
?>