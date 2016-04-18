<?php
namespace AchimFritz\ChampionShip\Competition\Domain\Event\Listener;

use TYPO3\Flow\Annotations as Flow;

/**
 * @Flow\Scope("singleton")
 */
class GroupMatch {

    /**
     * @param \AchimFritz\ChampionShip\Competition\Domain\Model\Match
     * @return void
     */
    public function onMatchChanged($match) {

    }
}

