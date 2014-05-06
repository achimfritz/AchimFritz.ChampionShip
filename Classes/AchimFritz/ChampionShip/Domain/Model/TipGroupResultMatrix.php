<?php
namespace AchimFritz\ChampionShip\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * A Tip
 *
 * @Flow\Entity
 */
class TipGroupResultMatrix {

	/**
	 * @var array<\AchimFritz\ChampionShip\Domain\Model\User>
	 * @ORM\ManyToMany
	 */
	protected $users;

	/**
	 * @var array<\AchimFritz\ChampionShip\Domain\Model\TipGroupResultMatrixRow>
	 * @ORM\ManyToMany
	 */
	protected $rows;

	/**
	 * setUsers 
	 * 
	 * @param array<\AchimFritz\ChampionShip\Domain\Model\TipGroupResultMatrixRow>
	 * @return void
	 */
	public function setUsers($users) {
		$this->users= $users;
	}

	/**
	 * getUsers
	 * 
	 * @return array<\AchimFritz\ChampionShip\Domain\Model\TipGroupResultMatrixRow>
	 */
	public function getUsers() {
		return $this->users;
	}

	/**
	 * setRows 
	 * 
	 * @param array<\AchimFritz\ChampionShip\Domain\Model\User>
	 * @return void
	 */
	public function setRows($rows) {
		$this->rows= $rows;
	}

	/**
	 * getRows
	 * 
	 * @return array<\AchimFritz\ChampionShip\Domain\Model\User>
	 */
	public function getRows() {
		return $this->rows;
	}


}
?>
