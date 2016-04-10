<?php
namespace AchimFritz\ChampionShip\Tip\Domain\Factory;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Competition\Domain\Model\Cup;
use AchimFritz\ChampionShip\User\Domain\Model\User;
use AchimFritz\ChampionShip\Tip\Domain\Model\Tip;
use AchimFritz\ChampionShip\Competition\Domain\Model\Match;
use \Doctrine\Common\Collections\ArrayCollection;

/**
 * A TipFactory
 *
 * @Flow\Scope("singleton")
 */
class TipFactory {

	/**
	 * @var \AchimFritz\ChampionShip\Tip\Domain\Repository\TipRepository
	 * @Flow\Inject
	 */
	protected $tipRepository;

	/**
	 * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\MatchRepository
	 * @Flow\Inject
	 */
	protected $matchRepository;

	/**
	 * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\CupRepository
	 * @Flow\Inject
	 */
	protected $cupRepository;

	/**
	 * checkUserTips 
	 * 
	 * @param Cup $cup 
	 * @param User $user 
	 * @return void
	 */
	public function checkUserTips(Cup $cup, User $user) {
		// init tips if match in future exists and use has no tips in cup
		$lastMatches = $this->matchRepository->findNextByCup($cup, 1);
		$lastMatch = $lastMatches->getFirst();
		if ($lastMatch instanceof Match) {
			$tips = $this->tipRepository->findByUserInCup($user, $cup);
			if (count($tips) === 0) {
				$newTips = $this->initTips($cup, $user);
			}
		}
	}

	/**
	 * initUserTipsForCurrentCup 
	 * 
	 * @param User $user 
	 * @return void
	 */
	public function initUserTipsForCurrentCup(User $user) {
		$cup = $this->cupRepository->findOneRecent();
		if (!$cup instanceof Cup) {
			throw new \Exception('no recent cup found', 1401293181);
		}
		$this->checkUserTips($cup, $user);
	}

	/**
	 * initTips 
	 * 
	 * @param Cup $cup
	 * @param User $user
	 * @return Collection<Tip>
	 */
	public function initTips(Cup $cup, User $user = NULL) {
		$existingTips = $this->tipRepository->findByUser($user);
		$tips = new ArrayCollection();
		$matches = $this->matchRepository->findByCup($cup);
		foreach ($matches AS $match) {
			$tipExists = FALSE;
			foreach ($existingTips AS $tip) {
				if ($tip->getMatch() === $match) {
					$tipExists = TRUE;
					continue 2;
				}
			}
			if ($tipExists === FALSE) {
				$tip = new Tip();
				$tip->setMatch($match);
				$tip->setUser($user);
				$this->tipRepository->add($tip);
				$tips->add($tip);
			}
		}
		return $tips;
	}

}
?>
