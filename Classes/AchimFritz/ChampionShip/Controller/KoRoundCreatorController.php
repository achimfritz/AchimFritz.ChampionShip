<?php
namespace AchimFritz\ChampionShip\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Domain\Model\Cup;

/**
 * Team controller for the AchimFritz.ChampionShip package 
 *
 * @Flow\Scope("singleton")
 */
class KoRoundCreatorController extends ActionController {


	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\KoRoundRepository
	 */
	protected $koRoundRepository;

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
	 * @var string
	 */
	protected $resourceArgumentName = 'cup';

	/**
	 * createAction
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\Cup $cup
	 * @return void
	 */
	public function createAction(Cup $cup) {
		$koRounds = $this->koRoundRepository->findByCup($cup);
		if (count($koRounds) > 0) {
			$this->addErrorMessage('koRounds already exists');
		} else {
			try {
				$groupRounds = $this->groupRoundRepository->findByCup($cup);
				$koRounds = $this->koRoundService->createKoRounds($groupRounds);
				foreach ($koRounds AS $koRound) {
					$this->koRoundRepository->add($koRound);
				}
				$this->addOkMessage('koRounds created');
			} catch (\Exception $e) {
				$this->addErrorMessage('cannot create koRounds');
				$this->handleException($e);
			}
		}
		$this->redirect('index', 'KoRound', NULL, array('cup' => $cup));
	}


}

?>
