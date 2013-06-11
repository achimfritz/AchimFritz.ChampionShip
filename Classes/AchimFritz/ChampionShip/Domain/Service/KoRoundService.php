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
	 * @var \AchimFritz\ChampionShip\Domain\Factory\MatchFactory
	 */
	protected $matchFactory;
		
	/**
	 * createKoRounds
	 * 
	 * @return \Doctrine\Common\Collections\Collection<\AchimFritz\ChampionShip\Domain\Model\KoRound>
	 */
	public function createKoRounds(\TYPO3\Flow\Persistence\Doctrine\QueryResult $groupRounds) {
		$koRounds = new \Doctrine\Common\Collections\ArrayCollection();
		$cnt = count($groupRounds);
		if ($cnt % 2 !== 0) {
			throw new Exception('need odd groupRounds, ' . $cnt . ' given', 1370282408);
		}
		$koRound = $this->createFromGroupRounds($groupRounds);
		$koRounds->add($koRound);
		for ($k = $cnt; $k > 0; $k = $k - 2) {
			$koRound = $this->createFromKoRound($koRound);
			$koRounds->add($koRound);
			
		}
		return $koRounds;
	}
	
	
	/**
	 * createFromParentKoRound
	 * 
	 * @param \AchimFritz\ChampionShip\Domain\Model\KoRound $parentKoRound
	 * @return \AchimFritz\ChampionShip\Domain\Model\KoRound
	 */
	protected function createFromKoRound(KoRound $parentKoRound) {
		$matches = $parentKoRound->getGeneralMatches();
		if (count($matches) === 2) {
			$koRound = new FinalRound();
		} else {
			$koRound = new KoRound();
		}
		$firstMatch = $matches[0];
		$koRound->setCup($firstMatch->getCup());
		$koRound->setName('1/' . (count($matches) / 2));
		$koRound->setParentRound($parentKoRound);
		for ($k = 0; $k < count($matches); $k = $k+2) {
			$first = $matches[$k];
			$second = $matches[$k+1];
			$match = $this->matchFactory->createInKoRoundFromMatches($koRound, $first, $second);		
			$koRound->addGeneralMatch($match);
		}
		return $koRound;
	}
	
	/**
	 * createFromGroupRounds
	 * 
	 * @param \TYPO3\Flow\Persistence\Doctrine\QueryResult<\AchimFritz\ChampionShip\Domain\Model\GroupRound>
	 * @return \AchimFritz\ChampionShip\Domain\Model\KoRound
	 */
	protected function createFromGroupRounds(\TYPO3\Flow\Persistence\Doctrine\QueryResult $groupRounds) {
		$koRound = new KoRound();
		$koRound->setName('1/' . count($groupRounds));
		$firstGroupRound = $groupRounds[0];
		$koRound->setCup($firstGroupRound->getCup());
		for ($k = 0; $k < count($groupRounds); $k = $k+2) {
			$first = $groupRounds[$k];
			$second = $groupRounds[$k+1];
			$match = $this->matchFactory->createInKoRoundFromGroupRounds($koRound, $first, $second);		
			$koRound->addGeneralMatch($match);
			$match = $this->matchFactory->createInKoRoundFromGroupRounds($koRound, $second, $first);		
			$koRound->addGeneralMatch($match);
		}
		return $koRound;
	}
	
	
}
?>
