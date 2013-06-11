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
	 * @var TYPO3\Flow\Persistence\PersistenceManagerInterface
	 */
	protected $persistenceManager;
	
	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\KoRoundRepository
	 */
	protected $koRoundRepository;
	
	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\FinalRoundRepository
	 */
	protected $finalRoundRepository;
		
	/**
	 * @var \AchimFritz\ChampionShip\Domain\Service\KoRoundService
	 * @Flow\Inject
	 */
	protected $koRoundService;
	
	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\GroupRoundRepository
	 */
	protected $groupRoundRepository;
	
	/**
	 * create
	 *
	 * @return void
	 */
	public function createCommand() {
		try {
			$groupRounds = $this->groupRoundRepository->findAll();
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
	 * cleanParents
	 * 
	 * @param \AchimFritz\ChampionShip\Domain\Model\KoRound $koRound
	 * @return void
	 */
	protected function cleanParent(\AchimFritz\ChampionShip\Domain\Model\KoRound $koRound = NULL) {
		if ($koRound !== NULL) {
			$this->outputLine('clean delete ' . $koRound->getName());
			$this->koRoundRepository->remove($koRound);
			$this->persistenceManager->persistAll();
			$this->cleanParent($koRound->getParentRound());
		}
	}
	
	/**
	 * clean
	 *
	 * @return void
	 */
	public function cleanCommand() {
				
		$finalRounds = $this->finalRoundRepository->findAll();
		$finalRound = $finalRounds->current();
		if ($finalRound instanceof \AchimFritz\ChampionShip\Domain\Model\FinalRound) {
			$this->finalRoundRepository->remove($finalRound);
			$this->persistenceManager->persistAll();
			$this->outputLine('clean delete ' . $finalRound->getName());
			$this->cleanParent($finalRound->getParentRound());
		} else {
			$this->outputLine('no final rounds found');
		}
	}

}

?>