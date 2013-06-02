<?php
namespace AchimFritz\ChampionShip\Domain\Service;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Domain\Model\MatchParticipant;
use AchimFritz\ChampionShip\Domain\Model\Match;
use AchimFritz\ChampionShip\Domain\Model\KoRound;


/**
 * A GroupRoundCalculatorService
 *
 * @Flow\Scope("singleton")
 */
class KoRoundService {
	
	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\MatchRepository
	 */
	protected $matchRepository;
	
	/**
	 * updateGroup
	 * 
	 * @param \AchimFritz\ChampionShip\Domain\Model\KoRound $koRound
	 * @return \AchimFritz\ChampionShip\Domain\Model\KoRound $koRound
	 */
	public function updateGroup(KoRound $koRound) {
		$koRound = $this->updateMatches($koRound);
		#$groupRound = $this->updateGroupTable($groupRound);
		return $koRound;
	}
	
	/**
	 * updateMatches
	 * 
	 * @param \AchimFritz\ChampionShip\Domain\Model\KoRound $koRound
	 * @return \AchimFritz\ChampionShip\Domain\Model\KoRound $koRound
	 */
	public function updateMatches(KoRound $koRound) {
		
		return $koRound;
	}
	
}
?>
