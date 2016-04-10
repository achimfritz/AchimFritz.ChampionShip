<?php
namespace AchimFritz\ChampionShip\Tip\Domain\Model;

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
class TipGroupResultMatrixRow {

	/**
	 * @var \AchimFritz\ChampionShip\Competition\Domain\Model\Match
	 * @ORM\OneToOne
	 * @Flow\Validate(type="NotEmpty")
	 */
	protected $generalMatch;

	/**
	 * @var array<\AchimFritz\ChampionShip\Tip\Domain\Model\Tip>
	 * @ORM\ManyToMany
	 */
	protected $tips;


	/**
	 * setMatch
	 *
	 * @param \AchimFritz\ChampionShip\Competition\Domain\Model\Match
	 * @return void
	 */
	public function setMatch($match) {
		$this->generalMatch = $match;
	}

	/**
	 * Get the Points's match
	 *
	 * @return \AchimFritz\ChampionShip\Competition\Domain\Model\Match The Points's match
	 */
	public function getMatch() {
		return $this->generalMatch;
	}

	/**
	 * setTips 
	 * 
	 * @param array<\AchimFritz\ChampionShip\Tip\Domain\Model\Tip>
	 * @return void
	 */
	public function setTips($tips) {
		$this->tips = $tips;
	}

	/**
	 * getTips 
	 * 
	 * @return array<\AchimFritz\ChampionShip\Tip\Domain\Model\Tip>
	 */
	public function getTips() {
		return $this->tips;
	}


}
?>
