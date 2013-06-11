<?php
namespace AchimFritz\ChampionShip\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * A Ko round
 *
 * @Flow\Entity
 */
class KoRound extends Round {

	/**
	 * The parent round
	 * @var \AchimFritz\ChampionShip\Domain\Model\KoRound
	 * @ORM\ManyToOne
	 */
	protected $parentRound;
	

	/**
	 * Get the Ko round's parent round
	 *
	 * @return \AchimFritz\ChampionShip\Domain\Model\KoRound The Ko round's parent round
	 */
	public function getParentRound() {
		return $this->parentRound;
	}

	/**
	 * Sets this Ko round's parent round
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\KoRound $parentRound The Ko round's parent round
	 * @return void
	 */
	public function setParentRound(\AchimFritz\ChampionShip\Domain\Model\KoRound $parentRound) {
		$this->parentRound = $parentRound;
	}
	
	
	/**
	 * getIsKoRound
	 * 
	 * @return boolean
	 */
	public function getIsKoRound() {
		return TRUE;
	}
	
	/**
	 * getIsGroupRound
	 * 
	 * @return boolean
	 */
	public function getIsGroupRound() {
		return FALSE;
	}

}
?>