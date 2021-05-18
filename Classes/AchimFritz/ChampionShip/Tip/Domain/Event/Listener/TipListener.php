<?php
namespace AchimFritz\ChampionShip\Tip\Domain\Event\Listener;

use AchimFritz\ChampionShip\Tip\Domain\Model\Tip;
use Neos\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Tip\Domain\Model\TipCup;
use AchimFritz\ChampionShip\Domain\Model\Result;

/**
 * @Flow\Scope("singleton")
 */
class TipListener
{

    /**
     * @var \AchimFritz\ChampionShip\Tip\Domain\Repository\TipCupRepository
     * @Flow\Inject
     */
    protected $tipCupRepository;

    /**
     * @param Tip $tip
     * @return void
     */
    public function onTipChanged(Tip $tip)
    {
        if ($tip->getResult() instanceof Result) {
            $tipCup = $this->tipCupRepository->findOneByCup($tip->getMatch()->getCup());
            if ($tipCup instanceof TipCup) {
                $name = $tipCup->getTipPointsPolicy();
                $tipPointsPolicy = new $name;
                $points = $tipPointsPolicy->getPointsForTip($tip);
                $tip->setPoints($points);
            }
        }
    }
}
