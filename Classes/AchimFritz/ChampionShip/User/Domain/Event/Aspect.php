<?php
namespace AchimFritz\ChampionShip\User\Domain\Event;

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
     * @Flow\Before("method(AchimFritz\ChampionShip\User\Domain\Repository\UserRepository->add())")
     */
    public function userAdded(JoinPointInterface $joinPoint)
    {
        $this->dispatcher->dispatch($joinPoint->getClassName(), 'userAdded', $joinPoint->getMethodArguments());
    }
}
