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
class KoRound extends Round {

	/**
	 * @var \Doctrine\Common\Collections\Collection<\AchimFritz\ChampionShip\Competition\Domain\Model\ChildKoRound>
	 * @ORM\OneToMany(mappedBy="parentRound", cascade={"remove"})
	 */
	protected $childKoRounds;

}
?>
