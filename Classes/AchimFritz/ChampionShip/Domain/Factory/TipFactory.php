<?php
namespace AchimFritz\ChampionShip\Domain\Factory;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Security\Account;
use AchimFritz\ChampionShip\Domain\Model\Cup;
use AchimFritz\ChampionShip\Domain\Model\Tip;
use \Doctrine\Common\Collections\Collection;

/**
 * A TipFactory
 *
 * @Flow\Scope("singleton")
 */
class TipFactory {

	/**
	 * createTips 
	 * 
	 * @param Account $account 
	 * @param Cup $cup 
	 * @return Collection<Tip>
	 */
	public function createTips(Account $account, Cup $cup) {
	}

}
?>
