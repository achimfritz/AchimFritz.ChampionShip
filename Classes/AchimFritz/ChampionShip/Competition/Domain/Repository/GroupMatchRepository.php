<?php
namespace AchimFritz\ChampionShip\Competition\Domain\Repository;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Competition\Domain\Model\GroupRound;
use AchimFritz\ChampionShip\Competition\Domain\Model\Result;
use AchimFritz\ChampionShip\Competition\Domain\Model\KoMatch;
use AchimFritz\ChampionShip\Competition\Domain\Model\GroupMatch;

/**
 * A repository for Matches
 *
 * @Flow\Scope("singleton")
 */
class GroupMatchRepository extends MatchRepository {

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\CrossGroupMatchRepository
	 */
	protected $koMatchRepository;

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\GroupRoundRepository
	 */
	protected $roundRepository;

	/**
	 * update 
	 * 
	 * @param mixed $object 
	 * @return void
	 */
	public function update($object) {
		$this->updateRound($object);
		parent::update($object);
	}

	/**
	 * add
	 * 
	 * @param mixed $object 
	 * @return void
	 */
	public function add($object) {
		$this->updateRound($object);
		parent::add($object);
	}

	/**
	 * updateRound 
	 * 
	 * @param GroupMatch $match 
	 * @return void
	 */
	protected function updateRound(GroupMatch $match) {
		if ($match->getRound() instanceof GroupRound) {
			$groupRound = $match->getRound();
			$groupRound->updateGroupTable();
			$this->roundRepository->update($groupRound);
		}
		if ($match->getResult() instanceof Result) {
			if ($match->getRound()->getRoundIsFinished() === TRUE) {
				$winnerTeam = $match->getRound()->getWinnerTeam();
				$secondTeam = $match->getRound()->getSecondTeam();
				$koMatch = $this->koMatchRepository->findOneInGroupRoundWithRank($match->getRound(), 1);
				if ($koMatch instanceof KoMatch) {
					if ($koMatch->getHostGroupRank() === 1) {
						$koMatch->setHostTeam($winnerTeam);
					} elseif ($koMatch->getGuestGroupRank() === 1) {
						$koMatch->setGuestTeam($winnerTeam);
					}
					$this->koMatchRepository->update($koMatch);
				}
				$otherKoMatch = $this->koMatchRepository->findOneInGroupRoundWithRank($match->getRound(), 2);
				if ($otherKoMatch instanceof KoMatch) {
					if ($otherKoMatch->getGuestGroupRank() === 2) {
						$otherKoMatch->setGuestTeam($secondTeam);
					} elseif ($otherKoMatch->getHostGroupRank() === 2) {
						$otherKoMatch->setHostTeam($secondTeam);
					}
					$this->koMatchRepository->update($otherKoMatch);
				}
			}
		}
	}

	
}
?>
