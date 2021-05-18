<?php
namespace AchimFritz\ChampionShip\Tip\Domain\Event;

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Aop\JoinPointInterface;

/**
 * @Flow\Scope("singleton")
 * @Flow\Aspect
 */
class Aspect
{

    /**
     * @Flow\Inject
     * @var \Neos\Flow\SignalSlot\Dispatcher
     */
    protected $dispatcher;

    /**
     * @param \Neos\Flow\Aop\JoinPointInterface $joinPoint
     * @return void
     * @Flow\Before("method(AchimFritz\ChampionShip\Tip\Domain\Repository\TipRepository->update())")
     */
    public function tipUpdated(JoinPointInterface $joinPoint)
    {
        $this->dispatcher->dispatch($joinPoint->getClassName(), 'tipUpdated', $joinPoint->getMethodArguments());
    }

    /**
     * @param \Neos\Flow\Aop\JoinPointInterface $joinPoint
     * @return void
     * @Flow\Before("method(AchimFritz\ChampionShip\Tip\Domain\Repository\TipRepository->add())")
     */
    public function tipAdded(JoinPointInterface $joinPoint)
    {
        $this->dispatcher->dispatch($joinPoint->getClassName(), 'tipAdded', $joinPoint->getMethodArguments());
    }
}
