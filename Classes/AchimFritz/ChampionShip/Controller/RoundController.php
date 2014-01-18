<?php
namespace AchimFritz\ChampionShip\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

use \AchimFritz\ChampionShip\Domain\Model\Round;
use \AchimFritz\ChampionShip\Domain\Model\Cup;

/**
 * GroupRound controller for the AchimFritz.ChampionShip package 
 *
 * @Flow\Scope("singleton")
 */
class RoundController extends ActionController {

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\RoundRepository
	 */
	protected $roundRepository;
	
	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\GroupRoundRepository
	 */
	protected $groupRoundRepository;
	
	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\KoRoundRepository
	 */
	protected $koRoundRepository;
	
	/**
	 * @var string
	 */
	protected $resourceArgumentName = 'round';

	/**
	 * listAction
	 * 
	 * @param \AchimFritz\ChampionShip\Domain\Model\Cup $cup
	 */
	public function listAction(Cup $cup) {
		$round = $this->roundRepository->findOneByCup($cup);
		if ($round instanceof Round) {
			$this->forward('show', NULL, NULL, array('round' => $round, 'cup' => $round->getCup()));
		} else {
			$this->view->assign('allGroupRounds', $this->groupRoundRepository->findByCup($cup));
			$this->addErrorMessage('no rounds found');
		}
	}

	/**
	 * showAction
	 * 
	 * @param \AchimFritz\ChampionShip\Domain\Model\Round $round
	 */
	public function showAction(Round $round) {
      $cup = $round->getCup();
		$this->view->assign('cup', $cup);
		$this->view->assign('round', $round);
      $this->view->assign('allKoRounds', $this->koRoundRepository->findByCup($cup));
      $this->view->assign('allGroupRounds', $this->groupRoundRepository->findByCup($cup));
	}


	/**
	 * Updates the given group round object
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\Round $round The group round to update
	 * @return void
	 */
	public function updateAction(Round $round) {
		try {
			$this->roundRepository->update($round);
			$this->persistenceManager->persistAll();
			$this->addOkMessage('round updatet');
		} catch (\Exception $e) {
			$this->addErrorMessage('cannot update round');
			$this->handleException($e);
		}
		$this->redirect('show', NULL, NULL, array('cup' => $round->getCup(), 'round' => $round));
	}

	/**
	 * Removes the given group round object from the group round repository
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\Round $round The group round to delete
	 * @return void
	 */
	public function deleteAction(Round $round) {
		$cup = $round->getCup();
		try {
			$this->roundRepository->remove($round);
			$this->persistenceManager->persistAll();
			$this->addOkMessage('round deletet');
		} catch (\Exception $e) {
			$this->addErrorMessage('cannot delete round');
			$this->handleException($e);
		}
		$this->redirect('list', NULL, NULL, array('cup' => $cup));
	}

}

?>
