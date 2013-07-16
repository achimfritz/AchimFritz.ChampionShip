<?php
namespace AchimFritz\ChampionShip\Domain\Service;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Domain\Model\KoRound;
use AchimFritz\ChampionShip\Domain\Model\FinalRound;


/**
 * A KoRoundService
 *
 * @Flow\Scope("singleton")
 */
class KoRoundService {
	
	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Factory\KoRoundFactory
	 */
	protected $koRoundFactory;
		
	/**
	 * createKoRounds
	 * 
	 * @return \Doctrine\Common\Collections\Collection<\AchimFritz\ChampionShip\Domain\Model\KoRound>
	 */
	public function createKoRounds(\TYPO3\Flow\Persistence\Doctrine\QueryResult $groupRounds) {
		$koRounds = new \Doctrine\Common\Collections\ArrayCollection();
		$cnt = count($groupRounds);
		if ($cnt % 2 !== 0 OR $cnt === 0) {
			throw new Exception('need odd groupRounds, ' . $cnt . ' given', 1370282408);
		}
		$koRound = $this->koRoundFactory->createFromGroupRounds($groupRounds);
		$koRounds->add($koRound);
		for ($k = $cnt; $k > 0; $k = $k - 2) {
			$koRound = $this->koRoundFactory->createFromKoRound($koRound);
			$koRounds->add($koRound);
			
		}
		return $koRounds;
	}
	
}
?>
