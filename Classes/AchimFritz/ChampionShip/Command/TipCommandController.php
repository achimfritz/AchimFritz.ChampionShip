<?php
namespace AchimFritz\ChampionShip\Command;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use \AchimFritz\ChampionShip\Domain\Model\Cup;
use \AchimFritz\ChampionShip\Domain\Model\Ranking;

/**
 * Point Command
 *
 * @Flow\Scope("singleton")
 */
class TipCommandController extends \TYPO3\Flow\Cli\CommandController {
	
	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\CupRepository
	 */
	protected $cupRepository;
	
	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\TipRepository
	 */
	protected $tipRepository;
	
	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\UserRepository
	 */
	protected $userRepository;

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\RoundRepository
	 */
	protected $roundRepository;
	
	/**
	 * listCommand
	 * 
	 * @return void
	 */
	public function listCommand() {
		$cup = $this->cupRepository->findOneByName('wm 2006');
		$user = $this->userRepository->findOneByUsername('af@achimfritz.de');
		$tips = $this->tipRepository->findByCup($cup);
		$this->outputLine('found ' . count($tips) . ' tips in cup ' . $cup->getName());
		$tips = $this->tipRepository->findByUserInCup($user, $cup);
		$this->outputLine('found ' . count($tips) . ' tips in cup ' . $cup->getName() . ' for user ' . $user->getName());
		$tips = $this->tipRepository->findGroupMatchTipsByUserInCup($user, $cup);
		$this->outputLine('found ' . count($tips) . ' groupMatch tips in cup ' . $cup->getName() . ' for user ' . $user->getName());
		$rounds = $this->roundRepository->findByCup($cup);
		foreach ($rounds AS $round) {
			$tips = $this->tipRepository->findMatchTipsByUserInRound($user, $round);
			$this->outputLine('found ' . count($tips) . ' tips in round ' . $round->getName() . ' for user ' . $user->getName());
		}
	}
}

?>
