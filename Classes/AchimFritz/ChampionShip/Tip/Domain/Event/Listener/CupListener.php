<?php
namespace AchimFritz\ChampionShip\Tip\Domain\Event\Listener;

use AchimFritz\ChampionShip\Competition\Domain\Model\Cup;
use AchimFritz\ChampionShip\Tip\Domain\Model\TipCup;
use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Tip\Domain\Model\CupRanking;

/**
 * @Flow\Scope("singleton")
 */
class CupListener
{

    /**
     * @var \AchimFritz\ChampionShip\Tip\Domain\Repository\TipRepository
     * @Flow\Inject
     */
    protected $tipRepository;

    /**
     * @var \AchimFritz\ChampionShip\Tip\Domain\Repository\TipCupRepository
     * @Flow\Inject
     */
    protected $tipCupRepository;

    /**
     * @var \AchimFritz\ChampionShip\Tip\Domain\Repository\CupRankingRepository
     * @Flow\Inject
     */
    protected $cupRankingRepository;

    /**
     * @param Cup $cup
     * @return void
     * @throws \TYPO3\Flow\Persistence\Exception\IllegalObjectTypeException
     */
    public function onCupRemoved(Cup $cup)
    {
        $tips = $this->tipRepository->findByCup($cup);
        foreach ($tips as $tip) {
            $this->tipRepository->remove($tip);
        }
        $tipCup = $this->tipCupRepository->findOneByCup($cup);
        if ($tipCup instanceof TipCup) {
            $this->tipCupRepository->remove($tipCup);
        }
        $cupRankings = $this->cupRankingRepository->findByCup($cup);
        foreach ($cupRankings as $cupRanking) {
            $this->cupRankingRepository->remove($cupRanking);
        }
    }
}
