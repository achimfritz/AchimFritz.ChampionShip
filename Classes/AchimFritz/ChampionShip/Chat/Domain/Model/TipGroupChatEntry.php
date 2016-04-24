<?php
namespace AchimFritz\ChampionShip\Chat\Domain\Model;

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
	 * @var \AchimFritz\ChampionShip\User\Domain\Model\TipGroup
	 * @ORM\ManyToOne
	 */
	protected $tipGroup;

	/**
	 * @return \AchimFritz\ChampionShip\User\Domain\Model\TipGroup
	 */
	public function getTipGroup() {
		return $this->tipGroup;
	}

	/**
	 * @param \AchimFritz\ChampionShip\User\Domain\Model\TipGroup $tipGroup
	 * @return void
	 */
	public function setTipGroup($tipGroup) {
		$this->tipGroup = $tipGroup;
	}

}
?>
