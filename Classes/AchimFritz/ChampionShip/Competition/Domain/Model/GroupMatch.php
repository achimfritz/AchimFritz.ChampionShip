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
class GroupMatch extends Match {
	
	/**
	 * @var \AchimFritz\ChampionShip\Competition\Domain\Model\GroupRound
	 * @ORM\ManyToOne
	 * @Flow\Validate(type="NotEmpty")
	 */
	protected $round;

	/**
	 * @var \AchimFritz\ChampionShip\Competition\Domain\Model\Team
	 * @ORM\ManyToOne
	 * @Flow\Validate(type="NotEmpty")
	 */
	protected $hostTeam;

	/**
	 * @var \AchimFritz\ChampionShip\Competition\Domain\Model\Team
	 * @ORM\ManyToOne
	 * @Flow\Validate(type="NotEmpty")
	 */
	protected $guestTeam;
	
}

