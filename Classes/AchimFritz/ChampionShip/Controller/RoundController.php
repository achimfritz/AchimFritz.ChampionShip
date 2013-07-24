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
	 * @var string
	 */
	protected $resourceArgumentName = 'round';

	/**
	 * listAction
	 * 
	 * @param \AchimFritz\ChampionShip\Domain\Model\Cup $cup
	 */
	public function listAction(Cup $cup) {
		$rounds = $this->roundRepository->findByCup($cup);
		$this->view->assign('rounds', $rounds);
	}

	/**
	 * showAction
	 * 
	 * @param \AchimFritz\ChampionShip\Domain\Model\Round $round
	 */
	public function showAction(Round $round) {
		$this->view->assign('round', $round);
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
		$this->redirect('list', 'Round', NULL, array('cup' => $cup));
	}

}

?>
