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
class GroupRoundTipController extends RoundController {

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\TipRepository
	 */
	protected $tipRepository;

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
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\GroupRoundRepository
	 */
	protected $roundRepository;
	
	/**
	 * showAction
	 * 
	 * @param \AchimFritz\ChampionShip\Domain\Model\Round $round
	 */
	public function showAction(Round $round) {
		$account = $this->securityContext->getAccount();
		$user = $this->userRepository->findOneByAccount($account);
		$tips = $this->tipRepository->findByUserInRound($user, $round);
		$this->view->assign('tips', $tips);
		$this->view->assign('round', $round);
	}


}

?>
