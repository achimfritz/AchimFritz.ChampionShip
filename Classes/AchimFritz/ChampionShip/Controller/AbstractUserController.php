<?php
namespace AchimFritz\ChampionShip\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Domain\Model\TipGroup;
use AchimFritz\ChampionShip\Domain\Model\User;

class AbstractUserController extends AbstractActionController {

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\TipGroupRepository
	 */
	protected $tipGroupRepository;

	/**
	 * initializeView 
	 * 
	 * @return void
	 */
	protected function initializeView(\TYPO3\Flow\Mvc\View\ViewInterface $view) {
		parent::initializeView($view);
		if ($this->user instanceof User) {
			$this->view->assign('tipGroups', $this->user->getTipGroups());
		} else {
			// admin only
			$this->view->assign('tipGroups', $this->tipGroupRepository->findAll());
		}
	}

}

?>
