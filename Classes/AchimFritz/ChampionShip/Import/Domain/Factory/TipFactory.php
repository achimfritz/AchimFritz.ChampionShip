<?php
namespace AchimFritz\ChampionShip\Import\Domain\Factory;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip.Import".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Competition\Domain\Model\Team;
use AchimFritz\ChampionShip\Competition\Domain\Model\Match;
use AchimFritz\ChampionShip\Competition\Domain\Model\Cup;
use AchimFritz\ChampionShip\Domain\Model\User;
use AchimFritz\ChampionShip\Competition\Domain\Model\Result;
use AchimFritz\ChampionShip\Domain\Model\TipGroup;
use AchimFritz\ChampionShip\Import\Domain\Model\Tip;

/**
 * TipFactory
 *
 * @Flow\Scope("singleton")
 */
class TipFactory
{

    /**
     * @var \AchimFritz\ChampionShip\Import\Domain\Factory\UserFactory
     * @Flow\Inject
     */
    protected $importUserFactory;

    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\KoMatchRepository
     */
    protected $koMatchRepository;

    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\GroupMatchRepository
     */
    protected $groupMatchRepository;

    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\TeamRepository
     */
    protected $teamRepository;

    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\Tip\Domain\Repository\TipRepository
     */
    protected $tipRepository;

    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\CupRepository
     */
    protected $cupRepository;

    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\User\Domain\Repository\UserRepository
     */
    protected $userRepository;

    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\User\Domain\Repository\TipGroupRepository
     */
    protected $tipGroupRepository;

    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\Import\Domain\Factory\UserMapperInterface
     */
    protected $userMapper;

    /**
     * createFromTip
     *
     * @param \AchimFritz\ChampionShip\Import\Domain\Model\Tip $tip
     * @return \AchimFritz\ChampionShip\Tip\Domain\Model\Tip
     */
    public function createFromTip(Tip $tip)
    {
        $cup = $this->cupRepository->findOneByName($tip->getCupName());
        #$name = html_entity_decode($tip->getHomeTeam(), ENT_COMPAT, 'UTF-8');
        $name = $tip->getHomeTeam();
        $homeTeam = $this->teamRepository->findOneByName($name);
        $homeName = $name;
        $name = $tip->getGuestTeam();
        $guestTeam = $this->teamRepository->findOneByName($name);
        if (!$cup instanceof Cup or !$homeTeam instanceof Team or !$guestTeam instanceof Team) {
            throw new \Exception('invalide objects '. $homeName . ' - ' . $name, 1380727272);
        }
        #var_dump($tip->getRoundType());
        if ($tip->getRoundType() == 1 or $tip->getRoundType() == 0) {
            $match = $this->groupMatchRepository->findOneByTwoTeamsAndCup($homeTeam, $guestTeam, $cup);
        } else {
            $match = $this->koMatchRepository->findOneByTwoTeamsAndCup($homeTeam, $guestTeam, $cup);
        }
        if (!$match instanceof Match) {
            throw new \Exception('no match found', 1380727273);
        }
        #$accountIdentifier = strtolower($tip->getUsername()) . '@' . strtolower($tip->getEmail());
        $accountIdentifier = $this->userMapper->mapName($tip->getUsername());
        $user = $this->userRepository->findOneByUserName($accountIdentifier);
        if (!$user instanceof User) {
            throw new \Exception('user not found ' . $accountIdentifier . ' - ' . $tip->getEmail() . '(' . $tip->getCupName() . ')', 1392564815);
            #$user = $this->userFactory->create(strtolower($tip->getEmail()), strtolower($tip->getUsername()));
        }
        $newTip = $this->tipRepository->findOneByUserAndMatch($user, $match);
        if (!$newTip instanceof \AchimFritz\ChampionShip\Domain\Model\Tip) {
            $newTip = new \AchimFritz\ChampionShip\Domain\Model\Tip();
            $newTip->setUser($user);
            $newTip->setMatch($match);
            $this->tipRepository->add($newTip);
        }
        if ($tip->getHomeTip() != 99 and $tip->getGuestTip() != 99) {
            if (!$newTip->getResult() instanceof Result) {
                $result = new Result();
                $newTip->setResult($result);
            }
            $newTip->getResult()->setHostTeamGoals($tip->getHomeTip());
            $newTip->getResult()->setGuestTeamGoals($tip->getGuestTip());
        }
        $this->tipRepository->update($newTip);
        return $newTip;
    }
}
