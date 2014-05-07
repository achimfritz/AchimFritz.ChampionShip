<?php
namespace AchimFritz\ChampionShip\Domain\Repository;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Domain\Model\GroupRound;
use AchimFritz\ChampionShip\Domain\Model\Result;
use AchimFritz\ChampionShip\Domain\Model\KoMatch;
use AchimFritz\ChampionShip\Domain\Model\GroupMatch;

/**
 * A repository for Matches
 *
 * @Flow\Scope("singleton")
 */
class GroupMatchRepository extends MatchRepository {

	/**
	 * @var \AchimFritz\ChampionShip\Domain\Service\GroupRoundService
	 * @Flow\Inject
	 */
	protected $groupRoundService;

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\CrossGroupMatchRepository
	 */
	protected $koMatchRepository;

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\GroupRoundRepository
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
		if ($match->getResult() instanceof Result) {
			$groupRound = $this->groupRoundService->updateGroupTable($match->getRound());
			$this->roundRepository->update($groupRound);
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
