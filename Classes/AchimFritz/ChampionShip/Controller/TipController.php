<?php
namespace AchimFritz\ChampionShip\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use \AchimFritz\ChampionShip\Domain\Model\Tip;
use \AchimFritz\ChampionShip\Domain\Model\Result;

/**
 * Standard controller for the AchimFritz.ChampionShip package 
 *
 * @Flow\Scope("singleton")
 */
class TipController extends ActionController {

	/**
	 * @var \AchimFritz\ChampionShip\Domain\Repository\TipRepository
	 * @Flow\Inject
	 */
	protected $tipRepository;

	/**
	 * @var string
	 */
	protected $resourceArgumentName = 'tip';

	/**
	 * Index action
	 *
	 * @return void
	 */
	public function showAction(Tip $tip) {
		$this->view->assign('tip', $tip);
		$this->view->assign('cup', $tip->getMatch()->getCup());
	}

	/**
	 * UpdateAction
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\Tip
	 * @return void
	 */
	public function updateAction(Tip $tip) {
		try {
			$this->tipRepository->update($tip);
			$this->persistenceManager->persistAll();
			$this->addOkMessage('tip updated');
		} catch (\Exception $e) {
			$this->addErrorMessage('cannot update tip');
			$this->handleException($e);
		}
		$this->redirect('show', NULL, NULL, array('tip' => $tip, 'cup' => $tip->getMatch()->getCup()));
	}


}

?>
