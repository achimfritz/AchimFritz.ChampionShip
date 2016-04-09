<?php
namespace AchimFritz\ChampionShip\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Flow\Entity
 */
class TipGroupChatEntry extends ChatEntry {

	/**
	 * @var \AchimFritz\ChampionShip\Domain\Model\TipGroup
	 * @ORM\ManyToOne
	 */
	protected $tipGroup;

	/**
	 * @return \AchimFritz\ChampionShip\Domain\Model\TipGroup
	 */
	public function getTipGroup() {
		return $this->tipGroup;
	}

	/**
	 * @param \AchimFritz\ChampionShip\Domain\Model\TipGroup $tipGroup
	 * @return void
	 */
	public function setTipGroup($tipGroup) {
		$this->tipGroup = $tipGroup;
	}

}
?>
