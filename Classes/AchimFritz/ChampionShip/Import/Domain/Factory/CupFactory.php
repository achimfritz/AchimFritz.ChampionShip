<?php
namespace AchimFritz\ChampionShip\Import\Domain\Factory;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip.Import".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Competition\Domain\Model\Cup;
use AchimFritz\ChampionShip\Import\Domain\Model\Match;

/**
 * CupFactory
 *
 * @Flow\Scope("singleton")
 */
class CupFactory
{

   /**
    * @Flow\Inject
    * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\CupRepository
    */
    protected $cupRepository;

    /**
     * createFromMatch
     *
     * @param AchimFritz\ChampionShip\Import\Domain\Model\Match $match
     * @param array $teams
     * @return Cup $cup
     */
    public function createFromMatch(Match $match, array $teams)
    {
        $cup = $this->cupRepository->findOneByName($match->getCupName());
        if (!$cup instanceof Cup) {
            $cup = new Cup();
            $startDate = new \DateTime();
            $startDate->setTimestamp($match->getStartDate());
            $cup->setStartDate($startDate);
            $cup->setName($match->getCupName());
            $this->cupRepository->add($cup);
        }
        foreach ($teams as $team) {
            if (!$cup->hasTeam($team)) {
                $cup->addTeam($team);
            }
        }
        $this->cupRepository->update($cup);
        return $cup;
    }
}
