<?php
namespace AchimFritz\ChampionShip\Competition\Domain\Model;

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
class ChildKoRound extends KoRound {

	/**
	 * The parent round
	 * @var \AchimFritz\ChampionShip\Competition\Domain\Model\KoRound
	 * @ORM\ManyToOne
	 */
	protected $parentRound;

	/**
	 * Get the Ko round's parent round
	 *
	 * @return \AchimFritz\ChampionShip\Competition\Domain\Model\KoRound The Ko round's parent round
	 */
	public function getParentRound() {
		return $this->parentRound;
	}

	/**
	 * Sets this Ko round's parent round
	 *
	 * @param \AchimFritz\ChampionShip\Competition\Domain\Model\KoRound $parentRound The Ko round's parent round
	 * @return void
	 */
	public function setParentRound(KoRound $parentRound) {
		$this->parentRound = $parentRound;
	}
}
?>
