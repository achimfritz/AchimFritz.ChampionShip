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
class GroupRoundCommandController extends \TYPO3\Flow\Cli\CommandController {
	
	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\GroupRoundRepository
	 */
	protected $groupRoundRepository;
	
	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\MatchRepository
	 */
	protected $matchRepository;
	
	/**
	 * @var \AchimFritz\ChampionShip\Domain\Service\GroupRoundService
	 * @Flow\Inject
	 */
	protected $groupRoundService;

	/**
	 * update
	 *
	 * @return void
	 */
	public function updateCommand() {
		$groupRounds = $this->groupRoundRepository->findAll();
		foreach ($groupRounds AS $groupRound) {
			$this->outputLine('update groupRound ' . $groupRound->getName());
			$this->groupRoundService->updateGroup($groupRound);
			$this->groupRoundRepository->update($groupRound);
		}
	}
	
	/**
	 * clean
	 *
	 * @return void
	 */
	public function cleanCommand() {
		$groupRounds = $this->groupRoundRepository->findAll();
		foreach ($groupRounds AS $groupRound) {
			$this->outputLine('clean groupRound ' . $groupRound->getName());
			$matches = $groupRound->getGeneralMatches();
			$this->outputLine('count of matches: ' . count($matches));
			foreach ($matches AS $match) {
				$this->matchRepository->remove($match);
			}
		}
	}

}

?>