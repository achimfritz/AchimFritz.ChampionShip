<?php
namespace AchimFritz\ChampionShip\Domain\Factory;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Security\Account;
use AchimFritz\ChampionShip\Domain\Model\User;
use AchimFritz\ChampionShip\Domain\Model\Tip;
use \Doctrine\Common\Collections\Collection;

/**
 * A TipFactory
 *
 * @Flow\Scope("singleton")
 */
class TipFactory {

	/**
	 * @var \AchimFritz\ChampionShip\Domain\Repository\TipRepository
	 * @Flow\Inject
	 */
	protected $tipRepository;

	/**
	 * @var \AchimFritz\ChampionShip\Domain\Repository\MatchRepository
	 * @Flow\Inject
	 */
	protected $matchRepository;

	/**
	 * createTips 
	 * 
	 * @param User $user
	 * @return Collection<Tip>
	 */
	public function initTips(User $user) {
		$tips = $this->tipRepository->findByUser($user);
		$matches = $this->matchRepository->findAll();
		foreach ($matches AS $match) {
		}
		return $tips;
	}

}
?>
