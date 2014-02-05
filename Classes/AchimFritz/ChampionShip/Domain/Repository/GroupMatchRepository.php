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
		if ($object->getResult() instanceof Result) {
			$groupRound = $this->groupRoundService->updateGroupTable($object->getRound());
			$this->roundRepository->update($groupRound);
			if ($object->getRound()->getRoundIsFinished() === TRUE) {
				// TODO crossGroupRoundService->setWinner()...
				$winnerTeam = $object->getRound()->getWinnerTeam();
				$secondTeam = $object->getRound()->getSecondTeam();
				$koMatch = $this->koMatchRepository->findOneInGroupRoundWithRank($object->getRound(), 1);
				if ($koMatch instanceof KoMatch) {
					if ($koMatch->getHostGroupRank() === 1) {
						$koMatch->setHostTeam($winnerTeam);
					} elseif ($koMatch->getGuestGroupRank() === 1) {
						$koMatch->setGuestTeam($winnerTeam);
					}
					$this->koMatchRepository->update($koMatch);
				}
				$otherKoMatch = $this->koMatchRepository->findOneInGroupRoundWithRank($object->getRound(), 2);
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
		parent::update($object);
	}

	
}
?>
