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
	 * @var \AchimFritz\ChampionShip\Domain\Factory\TipFactory
	 * @Flow\Inject
	 */
	protected $tipFactory;

	/**
	 * Index action
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\Tip $tip 
	 * @return void
	 */
	public function showAction(Tip $tip) {
		$this->view->assign('tip', $tip);
		$match = $tip->getMatch();
		$tips = $this->tipRepository->findByGeneralMatch($match);
		$this->view->assign('tips', $tips);
		$this->view->assign('cup', $match->getCup());
	}

	/**
	 * updateAction 
	 * 
	 * @param \AchimFritz\ChampionShip\Domain\Model\Tip $tip 
	 * @return void
	 */
	public function updateAction(Tip $tip) {
		$this->updateTip($tip);
		$this->redirect('index', NULL, NULL, array('tip' => $tip));
	}

	/**
	 * UpdateTip
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\Tip
	 * @return void
	 */
	public function updateTip(Tip $tip) {
		try {
			$this->tipRepository->update($tip);
			$this->persistenceManager->persistAll();
			$this->addOkMessage('tip updated');
		} catch (\Exception $e) {
			$this->addErrorMessage('cannot update tip');
			$this->handleException($e);
		}
	}

}

?>
