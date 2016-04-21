<?php
namespace AchimFritz\ChampionShip\Competition\Domain\Event\Listener;

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Competition\Domain\Model\GroupMatch;

/**
 * @Flow\Scope("singleton")
 */
class GroupMatchListener {

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\GroupRoundRepository
	 */
	protected $roundRepository;

	/**
	 * @param GroupMatch $match
	 * @return void
	 */
	public function onMatchUpdated(GroupMatch $match) {
		$groupRound = $match->getRound();
		$groupRound->updateGroupTable();
		$this->roundRepository->update($groupRound);
	}

	/**
	 * @param GroupMatch $match
	 * @return void
	 */
	public function onMatchAdded(GroupMatch $match) {
		$groupRound = $match->getRound();
		$groupRound->updateGroupTable();
		$this->roundRepository->update($groupRound);
	}
}

