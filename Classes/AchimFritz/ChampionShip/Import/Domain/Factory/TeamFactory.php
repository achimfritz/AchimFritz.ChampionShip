<?php
namespace AchimFritz\ChampionShip\Import\Domain\Factory;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip.Import".*
 *                                                                        *
 *                                                                        */

use Neos\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Competition\Domain\Model\Team;
use AchimFritz\ChampionShip\Import\Domain\Model\Match;

/**
 * TeamFactory
 *
 * @Flow\Scope("singleton")
 */
class TeamFactory
{

    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\TeamRepository
     */
    protected $teamRepository;

    /**
     * @param \AchimFritz\ChampionShip\Import\Domain\Model\Match $match
     * @return array<Team>
     */
    public function createFromMatch(Match $match)
    {
        $teams = array();
        $name = $match->getHomeTeam();
        $pTeam = $this->teamRepository->findOneByName($name);
        if (!$pTeam instanceof Team) {
            throw new \Exception('team not found ' . $name);
        }
        $teams[$name] = $pTeam;
        $name = $match->getGuestTeam();
        $pTeam = $this->teamRepository->findOneByName($name);
        if (!$pTeam instanceof Team) {
            throw new \Exception('team not found ' . $name);
        }
        $teams[$name] = $pTeam;
        return $teams;
    }

    /**
     * @param \AchimFritz\ChampionShip\Import\Domain\Model\Team $team
     * @param \AchimFritz\ChampionShip\Competition\Domain\Model\Team $team
     */
    public function createFromTeam(\AchimFritz\ChampionShip\Import\Domain\Model\Team $team)
    {
        $pTeam = $this->teamRepository->findOneByName($team->getNameDe());
        if (!$pTeam instanceof Team) {
            $pTeam = new Team();
            $pTeam->setName($team->getNameDe());
            $this->teamRepository->add($pTeam);
        }
        $pTeam->setNameDe($team->getNameDe());
        $pTeam->setNameLocal($team->getNameLocal());
        $pTeam->setNameEn($team->getNameEn());
        $pTeam->setIso2($team->getIso2());
        $pTeam->setIso3($team->getIso3());
        $this->teamRepository->update($pTeam);
        return $pTeam;
    }
}
