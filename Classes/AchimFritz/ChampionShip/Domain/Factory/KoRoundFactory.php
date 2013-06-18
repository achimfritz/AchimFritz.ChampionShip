<?php
namespace AchimFritz\ChampionShip\Domain\Factory;

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
class KoRoundFactory {

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Factory\MatchFactory
	 */
	protected $matchFactory;


	/**
	 * createFromParentKoRound
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\KoRound $parentKoRound
	 * @return \AchimFritz\ChampionShip\Domain\Model\KoRound
	 */
	public function createFromKoRound(KoRound $parentKoRound) {
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
			$match = $this->matchFactory->createFromWinners($first, $second);
			$n = $k + 1;
			$match->setName($koRound->getName() . '-' . $n);
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
	public function createFromGroupRounds(\TYPO3\Flow\Persistence\Doctrine\QueryResult $groupRounds) {
		$koRound = new KoRound();
		$koRound->setName('1/' . count($groupRounds));
		$firstGroupRound = $groupRounds[0];
		$koRound->setCup($firstGroupRound->getCup());
		for ($k = 0; $k < count($groupRounds); $k = $k+2) {
			$first = $groupRounds[$k];
			$second = $groupRounds[$k+1];
			$match = $this->matchFactory->createFromGroupRounds($first, $second);
			$n = $k + 1;
			$match->setName($koRound->getName() . '-' . $n);
			$koRound->addGeneralMatch($match);
			$match = $this->matchFactory->createFromGroupRounds($second, $first);
			$n = $k + 2;
			$match->setName($koRound->getName() . '-' . $n);
			$koRound->addGeneralMatch($match);
		}
		return $koRound;
	}
}
?>