<?php
namespace AchimFritz\ChampionShip\Competition\Domain\Event;

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Aop\JoinPointInterface;

/**
 * @Flow\Scope("singleton")
 * @Flow\Aspect
 */
class Aspect
{

    /**
     * @Flow\Inject
     * @var \TYPO3\Flow\SignalSlot\Dispatcher
     */
    protected $dispatcher;

    /**
     * @param \TYPO3\Flow\Aop\JoinPointInterface $joinPoint
     * @return void
     * @Flow\Before("method(AchimFritz\ChampionShip\Competition\Domain\Repository\MatchRepository->update())")
     */
    public function matchUpdated(JoinPointInterface $joinPoint)
    {
        $this->dispatcher->dispatch($joinPoint->getClassName(), 'matchUpdated', $joinPoint->getMethodArguments());
    }

    /**
     * @param \TYPO3\Flow\Aop\JoinPointInterface $joinPoint
     * @return void
     * @Flow\AfterReturning("method(AchimFritz\ChampionShip\Competition\Domain\Repository\MatchRepository->add())")
     */
    public function matchAdded(JoinPointInterface $joinPoint)
    {
        $this->dispatcher->dispatch($joinPoint->getClassName(), 'matchAdded', $joinPoint->getMethodArguments());
    }

    /**
     * @param \TYPO3\Flow\Aop\JoinPointInterface $joinPoint
     * @return void
     * @Flow\AfterReturning("method(AchimFritz\ChampionShip\Competition\Domain\Repository\MatchRepository->remove())")
     */
    public function matchRemoved(JoinPointInterface $joinPoint)
    {
        $this->dispatcher->dispatch($joinPoint->getClassName(), 'matchRemoved', $joinPoint->getMethodArguments());
    }

    /**
     * @param \TYPO3\Flow\Aop\JoinPointInterface $joinPoint
     * @return void
     * @Flow\AfterReturning("method(AchimFritz\ChampionShip\Competition\Domain\Model\KoRound->addGeneralMatch())")
     */
    public function matchAddedToRound(JoinPointInterface $joinPoint)
    {
        $this->dispatcher->dispatch($joinPoint->getClassName(), 'matchAddedToRound', $joinPoint->getMethodArguments());
    }

    /**
     * @param \TYPO3\Flow\Aop\JoinPointInterface $joinPoint
     * @return void
     * @Flow\AfterReturning("method(AchimFritz\ChampionShip\Competition\Domain\Repository\CupRepository->remove())")
     */
    public function cupRemoved(JoinPointInterface $joinPoint)
    {
        $this->dispatcher->dispatch($joinPoint->getClassName(), 'cupRemoved', $joinPoint->getMethodArguments());
    }

    /**
     * @param \TYPO3\Flow\Aop\JoinPointInterface $joinPoint
     * @return void
     * @Flow\AfterReturning("method(AchimFritz\ChampionShip\Competition\Domain\Repository\RoundRepository->remove())")
     */
    public function roundRemoved(JoinPointInterface $joinPoint)
    {
        $this->dispatcher->dispatch($joinPoint->getClassName(), 'roundRemoved', $joinPoint->getMethodArguments());
    }
}
