<?php
namespace AchimFritz\ChampionShip\Command;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

/**
 * GroupRound command controller for the AchimFritz.ChampionShip package
 *
 * @Flow\Scope("singleton")
 */
class KoRoundCommandController extends \TYPO3\Flow\Cli\CommandController {
	
	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\KoRoundRepository
	 */
	protected $koRoundRepository;
	
	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\MatchRepository
	 */
	protected $matchRepository;

	/**
	 * update
	 *
	 * @return void
	 */
	public function updateCommand() {
		$koRounds = $this->koRoundRepository->findAll();
		foreach ($koRounds AS $koRound) {
			$this->outputLine('update groupRound ' . $koRound->getName());
			$this->koRoundRepository->update($koRound);
		}
	}
	
	/**
	 * clean
	 *
	 * @return void
	 */
	public function cleanCommand() {
		$koRound = $this->groupRoundRepository->findAll();
		
		foreach ($koRounds AS $koRound) {
			$this->outputLine('clean groupRound ' . $koRound->getName());
			#$matches = $groupRound->getGeneralMatches();
			#$this->outputLine('count of matches: ' . count($matches));
			#foreach ($matches AS $match) {
			#	$this->matchRepository->remove($match);
			#}
		}
	}

}

?>