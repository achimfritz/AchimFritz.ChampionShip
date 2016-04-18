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
	 * @param \TYPO3\Flow\Aop\JoinPointInterface $joinPoint
	 * @return void
	 * @Flow\After("method(AchimFritz\ChampionShip\Competition\Domain\Repository\.*MatchRepository->update()) || method(AchimFritz\ChampionShip\Competition\Domain\Repository\.*MatchRepository->add())")
	 */
	public function matchChanged(JoinPointInterface $joinPoint) {
		$match = $joinPoint->getMethodArgument('object');

	}
}

