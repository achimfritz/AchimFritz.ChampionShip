<?php
namespace AchimFritz\ChampionShip\User\Domain\Event;

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Aop\JoinPointInterface;

/**
 * @Flow\Scope("singleton")
 * @Flow\Aspect
 */
class Aspect {

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\SignalSlot\Dispatcher
	 */
	protected $dispatcher;

	/**
	 * @param \TYPO3\Flow\Aop\JoinPointInterface $joinPoint
	 * @return void
	 * @Flow\Before("method(AchimFritz\ChampionShip\User\Domain\Repository\UserRepository->add())")
	 */
	public function userAdded(JoinPointInterface $joinPoint) {
		$this->dispatcher->dispatch($joinPoint->getClassName(), 'userAdded', $joinPoint->getMethodArguments());
	}

}

