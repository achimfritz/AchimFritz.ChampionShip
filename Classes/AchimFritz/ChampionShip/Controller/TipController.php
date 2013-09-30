<?php
namespace AchimFritz\ChampionShip\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use \AchimFritz\ChampionShip\Domain\Model\User;

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
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\UserRepository
	 */
	protected $userRepository;

	/**
	 * @var \TYPO3\Flow\Security\Context
	 * @Flow\Inject
	 */
	protected $securityContext;


	/**
	 * Index action
	 *
	 * @return void
	 */
	public function indexAction() {
		$account = $this->securityContext->getAccount();
		$user = $this->userRepository->findOneByAccout($account);
		$tips = $this->tipRepository->findGroupMatchesByUser($user);
		return count($tips);
	}

}

?>
