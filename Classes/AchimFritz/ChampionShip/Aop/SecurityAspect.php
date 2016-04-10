<?php
namespace AchimFritz\ChampionShip\Aop;

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Aop\JoinPointInterface;

/**
 * SecurityAspect 
 * 
 * @Flow\Scope("singleton")
 * @Flow\Aspect
 */
class SecurityAspect {

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Security\TipSecurity
	 */
	protected $tipSecurity;

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Security\UserSecurity
	 */
	protected $userSecurity;

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Security\ChatEntrySecurity
	 */
	protected $chatEntrySecurity;

	/**
	 * tipIsEditable 
	 * 
	 * @param \TYPO3\Flow\Aop\JoinPointInterface $joinPoint
	 * @throws Exception
	 * @return void
	 * @Flow\Before("method(AchimFritz\ChampionShip\Tip\Domain\Repository\TipRepository->update()) || method(AchimFritz\ChampionShip\Tip\Domain\Repository\TipRepository->add())")
	 */
	public function tipIsEditable(JoinPointInterface $joinPoint) {
		$tip = $joinPoint->getMethodArgument('object');
		if ($this->tipSecurity->editAllowed($tip) === FALSE) {
			throw new \Exception('tip is not editable', 1398952499);
		}
	}

	/**
	 * userIsEditable 
	 * 
	 * @param \TYPO3\Flow\Aop\JoinPointInterface $joinPoint
	 * @throws Exception
	 * @Flow\Before("method(AchimFritz\ChampionShip\User\Domain\Repository\UserRepository->update())")
	 * @return void
	 */
	public function userIsEditable(JoinPointInterface $joinPoint) {
		$user = $joinPoint->getMethodArgument('object');
		if ($this->userSecurity->editAllowed($user) === FALSE) {
			throw new \Exception('user is not editable', 1398952500);
		}
	}

	/**
	 * tipGroupChatEntriesMayBeFound 
	 * 
	 * @param JoinPointInterface $joinPoint 
	 * @throws Exception
	 * @Flow\Before("method(AchimFritz\ChampionShip\Chat\Domain\Repository\TipGroupChatEntryRepository->findByTipGroup())")
	 * @return void
	 */
	public function tipGroupChatEntriesMayBeFound(JoinPointInterface $joinPoint) {
		$tipGroup = $joinPoint->getMethodArgument('tipGroup');
		if ($this->chatEntrySecurity->accessAllowed($tipGroup) === FALSE) {
			throw new \Exception('user has no access to tipGroup', 1401296980);
		}
	}

	/**
	 * tipGroupChatEntryMayBeCreated
	 * 
	 * @param JoinPointInterface $joinPoint 
	 * @throws Exception
	 * @Flow\Before("method(AchimFritz\ChampionShip\Chat\Domain\Repository\TipGroupChatEntryRepository->add())")
	 * @return void
	 */
	public function tipGroupChatEntryMayBeCreated(JoinPointInterface $joinPoint) {
		$tipGroupChatEntry = $joinPoint->getMethodArgument('object');
		$tipGroup = $tipGroupChatEntry->getTipGroup();
		if ($this->chatEntrySecurity->accessAllowed($tipGroup) === FALSE) {
			throw new \Exception('user has no access to tipGroup', 1401296981);
		}
	}

}

?>
