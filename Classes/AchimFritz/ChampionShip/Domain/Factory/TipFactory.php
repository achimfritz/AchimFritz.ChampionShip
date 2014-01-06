<?php
namespace AchimFritz\ChampionShip\Domain\Factory;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Security\Account;
use AchimFritz\ChampionShip\Domain\Model\Cup;
use AchimFritz\ChampionShip\Domain\Model\User;
use AchimFritz\ChampionShip\Domain\Model\Tip;
use \Doctrine\Common\Collections\ArrayCollection;

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
	 * initTips 
	 * 
	 * @param Cup $cup
	 * @param User $user
	 * @return Collection<Tip>
	 */
	public function initTips(Cup $cup, User $user = NULL) {
		$existingTips = $this->tipRepository->findByUser($user);
		$tips = new ArrayCollection();
		#$matches = $this->matchRepository->findAll();
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
