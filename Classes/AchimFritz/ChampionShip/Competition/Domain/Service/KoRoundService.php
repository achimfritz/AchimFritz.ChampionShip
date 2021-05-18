<?php
namespace AchimFritz\ChampionShip\Competition\Domain\Service;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use Neos\Flow\Annotations as Flow;

/**
 * A KoRoundService
 *
 * @Flow\Scope("singleton")
 */
class KoRoundService
{
    
    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\Competition\Domain\Factory\KoRoundFactory
     */
    protected $koRoundFactory;
        
    /**
     * createKoRounds
     *
     * @return \Doctrine\Common\Collections\Collection<\AchimFritz\ChampionShip\Competition\Domain\Model\KoRound>
     */
    public function createKoRounds(\Neos\Flow\Persistence\Doctrine\QueryResult $groupRounds)
    {
        $koRounds = new \Doctrine\Common\Collections\ArrayCollection();
        $cnt = count($groupRounds);
        if ($cnt % 2 !== 0 or $cnt === 0 or (log($cnt, 2) !== round(log($cnt, 2)))) {
            throw new Exception('need odd groupRounds, ' . $cnt . ' given', 1370282408);
        }
        $koRound = $this->koRoundFactory->createFromGroupRounds($groupRounds);
        $koRounds->add($koRound);
        for ($k = $cnt; $k > 0; $k = $k - 2) {
            $koRound = $this->koRoundFactory->createFromKoRound($koRound);
            $koRounds->add($koRound);
        }
        return $koRounds;
    }
}
