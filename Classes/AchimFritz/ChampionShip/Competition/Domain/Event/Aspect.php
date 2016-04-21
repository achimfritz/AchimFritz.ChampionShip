<?php
namespace AchimFritz\ChampionShip\Competition\Domain\Event;

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
	 * @Flow\Before("method(AchimFritz\ChampionShip\Competition\Domain\Repository\.*MatchRepository->update())")
	 */
	public function matchUpdated(JoinPointInterface $joinPoint) {
		$this->dispatcher->dispatch($joinPoint->getClassName(), 'matchUpdated', $joinPoint->getMethodArguments());
	}

	/**
	 * @param \TYPO3\Flow\Aop\JoinPointInterface $joinPoint
	 * @return void
	 * @Flow\AfterReturning("method(AchimFritz\ChampionShip\Competition\Domain\Repository\.*MatchRepository->add())")
	 */
	public function matchAdded(JoinPointInterface $joinPoint) {
		$this->dispatcher->dispatch($joinPoint->getClassName(), 'matchAdded', $joinPoint->getMethodArguments());
	}
}

