<?php
namespace AchimFritz\ChampionShip\Tip\Domain\Event\Listener;


use AchimFritz\ChampionShip\Tip\Domain\Model\Tip;
use AchimFritz\ChampionShip\User\Domain\Model\User;
use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Competition\Domain\Model\Match;
use AchimFritz\ChampionShip\Domain\Model\Result;

/**
 * @Flow\Scope("singleton")
 */
class UserListener {

	/**
	 * @var \AchimFritz\ChampionShip\Tip\Domain\Repository\TipRepository
	 * @Flow\Inject
	 */
	protected $tipRepository;

	/**
	 * @param Match $match
	 * @return void
	 */
	public function onUserAdded(User $user) {
		$now = new \DateTime();

	}


}

