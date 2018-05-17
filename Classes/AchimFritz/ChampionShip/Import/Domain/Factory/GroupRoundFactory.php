<?php
namespace AchimFritz\ChampionShip\Import\Domain\Factory;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip.Import".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Competition\Domain\Model\GroupRound;
use AchimFritz\ChampionShip\Competition\Domain\Model\Cup;
use AchimFritz\ChampionShip\Import\Domain\Model\Match;

/**
 * GroupRoundFactory
 *
 * @Flow\Scope("singleton")
 */
class GroupRoundFactory
{

   /**
    * @Flow\Inject
    * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\GroupRoundRepository
    */
    protected $groupRoundRepository;

    /**
     * createFromMatch
     *
     * @param AchimFritz\ChampionShip\Import\Domain\Model\Match $match
      * @param array $teams
     * @param AchimFritz\ChampionShip\Competition\Domain\Model\Cup $cup
     * @return GroupRound $groupRound
     */
    public function createFromMatch(Match $match, array $teams, Cup $cup)
    {
        $groupRound = $this->groupRoundRepository->findOneByNameAndCup($match->getGroupName(), $cup);
        if (!$groupRound instanceof GroupRound) {
            $groupRound = new GroupRound();
            $this->groupRoundRepository->add($groupRound);
        }
        $groupRound->setCup($cup);
        $groupRound->setName($match->getGroupName());
        foreach ($teams as $team) {
            if (!$groupRound->hasTeam($team)) {
                $groupRound->addTeam($team);
            }
        }
        $this->groupRoundRepository->update($groupRound);
        return $groupRound;
    }
}
