<?php
namespace AchimFritz\ChampionShip\Tip\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use Neos\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * A Ranking
 *
 * @Flow\Entity
 */
class CupRanking extends AbstractRanking
{

    /**
     * @var \AchimFritz\ChampionShip\Competition\Domain\Model\Cup
     * @ORM\ManyToOne
     */
    protected $cup;

    /**
     * @return Cup
     */
    public function getCup()
    {
        return $this->cup;
    }

    /**
     * @param Cup $cup
     */
    public function setCup($cup)
    {
        $this->cup = $cup;
    }
}
