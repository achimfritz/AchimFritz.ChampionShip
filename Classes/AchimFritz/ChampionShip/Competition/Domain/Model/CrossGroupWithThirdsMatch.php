<?php
namespace AchimFritz\ChampionShip\Competition\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * A Match
 *
 * @Flow\Entity
 */
class CrossGroupWithThirdsMatch extends CrossGroupMatch {

	/**
	 * @var \Doctrine\Common\Collections\Collection<\AchimFritz\ChampionShip\Competition\Domain\Model\GroupRound>
	 * @ORM\ManyToMany
	 * @Flow\Validate(type="NotEmpty")
	 */
	protected $guestGroupRounds;

	/**
	 * @var integer
	 * @Flow\Validate(type="NotEmpty")
	 */
	protected $hostGroupRank = 1;

	/**
	 * @var \AchimFritz\ChampionShip\Competition\Domain\Model\GroupRound
	 * @ORM\ManyToOne
	 */
	protected $guestGroupRound;

	/**
	 * @var integer
	 * @Flow\Validate(type="NotEmpty")
	 */
	protected $guestGroupRank = 3;

	/**
	 * @return \Doctrine\Common\Collections\Collection<\AchimFritz\ChampionShip\Competition\Domain\Model\GroupRound>
	 */
	public function getGuestGroupRounds() {
		return $this->guestGroupRounds;
	}

	/**
	 * @param $guestGroupRound
	 * @return void
	 */
	public function setGuestGroupRounds($guestGroupRounds) {
		$this->guestGroupRounds = $guestGroupRounds;
	}
}
