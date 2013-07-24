<?php
namespace AchimFritz\ChampionShip\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

/**
 * Standard controller for the AchimFritz.ChampionShip package 
 *
 * @Flow\Scope("singleton")
 */
class TipController extends ActionController {

	/**
	 * Index action
	 *
	 * @return void
	 */
	public function indexAction() {
		return 'foo';
	}

}

?>