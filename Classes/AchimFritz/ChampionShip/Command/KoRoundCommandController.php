<?php
namespace AchimFritz\ChampionShip\Command;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use \AchimFritz\ChampionShip\Competition\Domain\Model\Cup;

/**
 * GroupRound command controller for the AchimFritz.ChampionShip package
 *
 * @Flow\Scope("singleton")
 */
class KoRoundCommandController extends \TYPO3\Flow\Cli\CommandController {

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\Persistence\PersistenceManagerInterface
	 */
	protected $persistenceManager;

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\KoRoundRepository
	 */
	protected $koRoundRepository;

	/**
	 * @var \AchimFritz\ChampionShip\Domain\Service\KoRoundService
	 * @Flow\Inject
	 */
	protected $koRoundService;

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\GroupRoundRepository
	 */
	protected $groupRoundRepository;

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\CupRepository
	 */
	protected $cupRepository;
	

	/**
	 * list
	 *
	 * @return void
	 */
	public function listCommand() {
		$koRounds = $this->koRoundRepository->findAll();
		if (count($koRounds)) {
			foreach ($koRounds AS $koRound) {
				$this->outputLine($koRound->getName());
				$matches = $koRound->getGeneralMatches();
				if (count($matches)) {
					foreach ($matches as $match) {
						$this->outputLine(' ' . $match->getName() . ' : ' . $match->getHostName() . ' - ' . $match->getGuestName());
					}
				} else {
					$this->outputLine(' no matches found');
				}
			}
		} else {
			$this->outputLine('no koRounds found');
		}
	}

	/**
	 * create($cupName)
	 *
	 * @param string $cupName
	 * @return void
	 */
	public function createCommand($cupName) {
		$cup = $this->cupRepository->findOneByName($cupName);
		if (!$cup instanceof Cup) {
			$this->outputLine('no such cup ' . $cupName);
			$this->quit();
		}
		$koRounds = $this->koRoundRepository->findByCup($cup);
		if (count($koRounds) > 0) {
			$this->outputLine('koRounds already exists');
			$this->quit();
			
		}
		try {
			$groupRounds = $this->groupRoundRepository->findByCup($cup);
			$koRounds = $this->koRoundService->createKoRounds($groupRounds);
		} catch (\Exception $e) {
			$this->outputLine('ERROR ' . $e->getMessage());
			$this->quit();
		}
		foreach ($koRounds AS $koRound) {
			$this->koRoundRepository->add($koRound);
			$this->outputLine('created koRound ' . $koRound->getName() . ' with ' . count($koRound->getGeneralMatches()) . ' matches');
		}
		$this->outputLine('DONE');
	}

	/**
	 * removeParents
	 *
	 * @param \AchimFritz\ChampionShip\Competition\Domain\Model\KoRound $koRound
	 * @return void
	 */
	protected function removeParent(\AchimFritz\ChampionShip\Competition\Domain\Model\KoRound $koRound = NULL) {
		if ($koRound !== NULL) {
			$this->outputLine('removed ' . $koRound->getName());
			$this->koRoundRepository->remove($koRound);
			$this->persistenceManager->persistAll();
			$this->removeParent($koRound->getParentRound());
		}
	}

	/**
	 * remove
	 *
	 * @return void
	 */
	public function removeCommand() {
/*
		$finalRounds = $this->finalRoundRepository->findAll();
		$finalRound = $finalRounds->current();
		if ($finalRound instanceof \AchimFritz\ChampionShip\Domain\Model\FinalRound) {
			$this->finalRoundRepository->remove($finalRound);
			$this->persistenceManager->persistAll();
			$this->outputLine('removed ' . $finalRound->getName());
			$this->removeParent($finalRound->getParentRound());
		} else {
			$this->outputLine('no final rounds found');
		}
*/
	}

}

?>
