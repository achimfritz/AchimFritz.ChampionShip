<?php
namespace AchimFritz\ChampionShip\Tip\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;


use AchimFritz\ChampionShip\User\Domain\Model\TipGroup;

/**
 * Team controller for the AchimFritz.ChampionShip package
 *
 * @Flow\Scope("singleton")
 */
class RankingController extends AbstractTipGroupController
{

    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\Tip\Domain\Repository\CupRankingRepository
     */
    protected $rankingRepository;

    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\User\Domain\Repository\UserRepository
     */
    protected $userRepository;

    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\MatchRepository
     */
    protected $matchRepository;

    /**
     * @var string
     */
    protected $resourceArgumentName = 'tipGroup';

    /**
     * @return void
     */
    public function listAction()
    {
        $rankings = $this->rankingRepository->findByCup($this->cup);
        $this->view->assign('rankings', $rankings);
    }

    /**
     * @param \AchimFritz\ChampionShip\User\Domain\Model\TipGroup $tipGroup
     * @return void
     */
    public function showAction(TipGroup $tipGroup)
    {
        $users = $this->userRepository->findInTipGroup($tipGroup);
        $rankings = $this->rankingRepository->findByUsersAndCup($users, $this->cup);
        $this->view->assign('rankings', $rankings);
        $this->view->assign('tipGroup', $tipGroup);
    }
}
