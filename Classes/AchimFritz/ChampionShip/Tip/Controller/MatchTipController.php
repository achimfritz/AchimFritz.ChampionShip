<?php
namespace AchimFritz\ChampionShip\Tip\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use AchimFritz\ChampionShip\User\Domain\Model\TipGroup;
use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Competition\Domain\Model\Cup;
use AchimFritz\ChampionShip\Competition\Domain\Model\Match;


/**
 * Standard controller for the AchimFritz.ChampionShip package 
 *
 * @Flow\Scope("singleton")
 */
class MatchTipController extends AbstractTipGroupController {

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\MatchRepository
	 */
	protected $matchRepository;

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Tip\Domain\Repository\TipRepository
	 */
	protected $tipRepository;

	/**
	 * @var string
	 */
	protected $resourceArgumentName = 'match';

	/**
	 * @param \AchimFritz\ChampionShip\Competition\Domain\Model\Cup $cup
	 */
	public function listAction(Cup $cup) {
		$matches = $this->matchRepository->findByCup($cup);
		$this->view->assign('matches', $matches);
	}

	/**
	 * @param \AchimFritz\ChampionShip\Competition\Domain\Model\Match $match
	 * @param \AchimFritz\ChampionShip\User\Domain\Model\TipGroup $tipGroup
	 * @param 
	 */
	public function showAction(Match $match, TipGroup $tipGroup = NULL) {
		if ($tipGroup === NULL) {
			if ($this->user instanceof User) {
				$tipGroup = $this->user->getTipGroup();
			} else {
				// admin only
				$tipGroup = $this->tipGroupRepository->findAll()->getFirst();
			}
		}
		$users = $this->userRepository->findInTipGroup($tipGroup);
		$tips = $this->tipRepository->findByUsersAndMatch($users, $match);
		$this->view->assign('tipGroup', $tipGroup);
		$this->view->assign('tips', $tips);
		$this->view->assign('match', $match);
	}
	


}
