<?php
namespace AchimFritz\ChampionShip\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

use \AchimFritz\ChampionShip\Domain\Model\User;
use \AchimFritz\ChampionShip\Domain\Model\Match;
use \AchimFritz\ChampionShip\Domain\Model\KoRound;
use \AchimFritz\ChampionShip\Domain\Model\GroupRound;
use \AchimFritz\ChampionShip\Domain\Model\Cup;

/**
 * Match controller for the AchimFritz.ChampionShip package 
 *
 * @Flow\Scope("singleton")
 */
class GroupMatchTipController extends ActionController {
		
	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\TipRepository
	 */
	protected $tipRepository;

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\GroupMatchRepository
	 */
	protected $matchRepository;

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
	 * @var \AchimFritz\ChampionShip\Domain\Factory\TipFactory
	 * @Flow\Inject
	 */
	protected $tipFactory;
	
	/**
	 * listAction
	 * 
	 * @param \AchimFritz\ChampionShip\Domain\Model\Cup $cup
	 */
	public function listAction(Cup $cup) {
		$account = $this->securityContext->getAccount();
		$user = $this->userRepository->findOneByAccount($account);
		if (!$user instanceof User) {
			$this->addErrorMessage('no user found');
		} else {
			$matches = $this->matchRepository->findByCup($cup);
			$tips = $this->tipRepository->findByUserInMatches($user, $matches);
			if (count($matches) != count($tips)) {
				$newTips = $this->tipFactory->initTips($cup, $user);
				$this->persistenceManager->persistAll();
				$tips = $this->tipRepository->findByUserInMatches($user, $matches);
			}
			$this->view->assign('tips', $tips);
		}
	}

}

?>
