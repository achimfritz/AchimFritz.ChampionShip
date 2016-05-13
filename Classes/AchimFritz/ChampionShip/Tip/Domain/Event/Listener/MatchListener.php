<?php
namespace AchimFritz\ChampionShip\Tip\Domain\Event\Listener;


use AchimFritz\ChampionShip\Tip\Domain\Model\Tip;
use AchimFritz\ChampionShip\Tip\Domain\Model\TipCup;
use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Competition\Domain\Model\Match;
use AchimFritz\ChampionShip\Domain\Model\Result;

/**
 * @Flow\Scope("singleton")
 */
class MatchListener {

	/**
	 * @var \AchimFritz\ChampionShip\User\Domain\Repository\UserRepository
	 * @Flow\Inject
	 */
	protected $userRepository;

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
	 * @param Match $match
	 * @return void
	 */
	public function onMatchChanged(Match $match) {
		$now = new \DateTime();
		if ($match->getStartDate() >= $now) {
			$users = $this->userRepository->findAll();
			foreach ($users as $user) {
				$tip = $this->tipRepository->findOneByUserAndMatch($user, $match);
				if ($tip instanceof Tip === FALSE) {
					$tip = new Tip();
					$tip->setMatch($match);
					$tip->setUser($user);
					$this->tipRepository->add($tip);
				}
			}
		}
		if ($match->getResult() instanceof Result) {
			$tipCup = $this->tipCupRepository->findOneByCup($match->getCup());
			if ($tipCup instanceof TipCup) {
				$name = $tipCup->getTipPointsPolicy();
				$tipPointsPolicy = new $name;
				$tips = $this->tipRepository->findByGeneralMatch($match);
				foreach ($tips AS $tip) {
					$points = $tipPointsPolicy->getPointsForTip($tip);
					$tip->setPoints($points);
					$this->tipRepository->update($tip);
				}
			}
		}
	}

	/**
	 * @param Match $match
	 * @return void
	 */
	public function onMatchRemoved(Match $match) {
		$users = $this->userRepository->findAll();
		foreach ($users as $user) {
			$tip = $this->tipRepository->findOneByUserAndMatch($user, $match);
			if ($tip instanceof Tip === TRUE) {
				$this->tipRepository->remove($tip);
			}
		}
	}

}

