<?php
namespace AchimFritz\ChampionShip;

use Neos\Flow\Package\Package as BasePackage;
use Neos\Flow\Annotations as Flow;

/**
 * @Flow\Scope("singleton")
 */
class Package extends BasePackage
{

    /**
     * Boot the package. We wire some signals to slots here.
     *
     * @param \Neos\Flow\Core\Bootstrap $bootstrap The current bootstrap
     * @return void
     */
    public function boot(\Neos\Flow\Core\Bootstrap $bootstrap)
    {
        $dispatcher = $bootstrap->getSignalSlotDispatcher();
        $dispatcher->connect(
            'AchimFritz\ChampionShip\Competition\Domain\Repository\MatchRepository',
            'matchAdded',
            'AchimFritz\ChampionShip\Competition\Domain\Event\Listener\MatchListener',
            'onMatchChanged'
        );
        $dispatcher->connect(
            'AchimFritz\ChampionShip\Competition\Domain\Repository\MatchRepository',
            'matchUpdated',
            'AchimFritz\ChampionShip\Competition\Domain\Event\Listener\MatchListener',
            'onMatchChanged'
        );
        $dispatcher->connect(
            'AchimFritz\ChampionShip\Competition\Domain\Repository\MatchRepository',
            'matchRemoved',
            'AchimFritz\ChampionShip\Competition\Domain\Event\Listener\MatchListener',
            'onMatchRemoved'
        );


        $dispatcher->connect(
            'AchimFritz\ChampionShip\Competition\Domain\Repository\MatchRepository',
            'matchAdded',
            'AchimFritz\ChampionShip\Tip\Domain\Event\Listener\MatchListener',
            'onMatchChanged'
        );
        $dispatcher->connect(
            'AchimFritz\ChampionShip\Competition\Domain\Repository\MatchRepository',
            'matchUpdated',
            'AchimFritz\ChampionShip\Tip\Domain\Event\Listener\MatchListener',
            'onMatchChanged'
        );
        $dispatcher->connect(
            'AchimFritz\ChampionShip\Competition\Domain\Repository\MatchRepository',
            'matchRemoved',
            'AchimFritz\ChampionShip\Tip\Domain\Event\Listener\MatchListener',
            'onMatchRemoved'
        );
        $dispatcher->connect(
            'AchimFritz\ChampionShip\Competition\Domain\Repository\CupRepository',
            'cupRemoved',
            'AchimFritz\ChampionShip\Tip\Domain\Event\Listener\CupListener',
            'onCupRemoved'
        );
        $dispatcher->connect(
            'AchimFritz\ChampionShip\Competition\Domain\Repository\RoundRepository',
            'roundRemoved',
            'AchimFritz\ChampionShip\Tip\Domain\Event\Listener\RoundListener',
            'onRoundRemoved'
        );

        $dispatcher->connect(
            'AchimFritz\ChampionShip\Tip\Domain\Repository\TipRepository',
            'tipAdded',
            'AchimFritz\ChampionShip\Tip\Domain\Event\Listener\TipListener',
            'onTipChanged'
        );
        $dispatcher->connect(
            'AchimFritz\ChampionShip\Tip\Domain\Repository\TipRepository',
            'tipUpdated',
            'AchimFritz\ChampionShip\Tip\Domain\Event\Listener\TipListener',
            'onTipChanged'
        );

        $dispatcher->connect(
            'AchimFritz\ChampionShip\User\Domain\Repository\UserRepository',
            'userAdded',
            'AchimFritz\ChampionShip\Tip\Domain\Event\Listener\UserListener',
            'onUserAdded'
        );
    }
}
