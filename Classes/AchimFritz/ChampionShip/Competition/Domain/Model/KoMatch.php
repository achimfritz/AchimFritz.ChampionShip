<?php
namespace AchimFritz\ChampionShip\Competition\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use Neos\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * A Match
 *
 * @Flow\Entity
 */
class KoMatch extends Match
{
    
    /**
     * @var \AchimFritz\ChampionShip\Competition\Domain\Model\KoRound
     * @ORM\ManyToOne
     * @Flow\Validate(type="NotEmpty")
     */
    protected $round;
}
