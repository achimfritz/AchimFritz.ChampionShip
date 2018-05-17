<?php
namespace AchimFritz\ChampionShip\Tip\Domain\Event\Listener;

use AchimFritz\ChampionShip\Competition\Domain\Model\Round;
use TYPO3\Flow\Annotations as Flow;

/**
 * @Flow\Scope("singleton")
 */
class RoundListener
{

    /**
     * @var \AchimFritz\ChampionShip\Tip\Domain\Repository\TipRepository
     * @Flow\Inject
     */
    protected $tipRepository;

    /**
     * @param Round $round
     * @return void
     * @throws \TYPO3\Flow\Persistence\Exception\IllegalObjectTypeException
     */
    public function onRoundRemoved(Round $round)
    {
        $tips = $this->tipRepository->findByRound($round);
        foreach ($tips as $tip) {
            $this->tipRepository->remove($tip);
        }
    }
}
