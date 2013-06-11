<?php
namespace AchimFritz\ChampionShip\Domain\Service;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Domain\Model\GroupTableRow;
use AchimFritz\ChampionShip\Domain\Model\MatchParticipant;
use AchimFritz\ChampionShip\Domain\Model\Match;
use AchimFritz\ChampionShip\Domain\Model\GroupRound;


/**
 * A GroupRoundService
 *
 * @Flow\Scope("singleton")
 */
class GroupRoundService {
	
	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\MatchRepository
	 */
	protected $matchRepository;
	
	/**
	 * updateGroup
	 * 
	 * @param \AchimFritz\ChampionShip\Domain\Model\GroupRound $groupRound
	 * @return \AchimFritz\ChampionShip\Domain\Model\GroupRound $groupRound
	 */
	public function updateGroup(GroupRound $groupRound) {
		$groupRound = $this->updateMatches($groupRound);
		$groupRound = $this->updateGroupTable($groupRound);
		return $groupRound;
	}
	
	/**
	 * updateGroupTable
	 * 
	 * @param \AchimFritz\ChampionShip\Domain\Model\GroupRound $groupRound
	 * @return \AchimFritz\ChampionShip\Domain\Model\GroupRound $groupRound
	 */
	protected function updateGroupTable(GroupRound $groupRound) {
		$teams = $groupRound->getTeams();
		$groupRound->clearGroupTableRows();
		$rank = 1;
		foreach ($teams AS $team) {
			$groupTableRow = new GroupTableRow();
			$groupTableRow->setRank($rank);
			$groupTableRow->setPoints(0);
			$groupTableRow->setGoalsPlus(0);
			$groupTableRow->setGroupRound($groupRound);
			$groupTableRow->setTeam($team);
			$groupRound->addGroupTableRow($groupTableRow);
			$rank++;
		}
		return $groupRound;
	}
	
	/**
	 * updateMatches
	 * 
	 * @param \AchimFritz\ChampionShip\Domain\Model\GroupRound $groupRound
	 * @return \AchimFritz\ChampionShip\Domain\Model\GroupRound $groupRound
	 */
	protected function updateMatches(GroupRound $groupRound) {
		$teams = $groupRound->getTeams();
		if (count($teams) === 0) {
			return $groupRound;
		}
		$existingMatches = $groupRound->getGeneralMatches();		
		$teamPairs = $this->getTeamPairs($teams);

		foreach ($teamPairs AS $teamPair) {
			$matchExists = FALSE;
			if (count($existingMatches) !== 0) {
				foreach ($existingMatches AS $existingMatch) {
					if ($existingMatch->getTwoTeamsPlayThisMatch($teamPair['teamOne'], $teamPair['teamTwo'])) {
						$matchExists = TRUE;
						continue;
					}
				}
			}
			if ($matchExists === FALSE) {
					// TODO MatchFactory->createByRoundAndTeams()
				$hostParticipant = new MatchParticipant();
				$hostParticipant->setTeam($teamPair['teamOne']);
				$guestParticipant = new MatchParticipant();
				$guestParticipant->setTeam($teamPair['teamTwo']);
				$match = new Match();
				$match->setHostParticipant($hostParticipant);
				$match->setGuestParticipant($guestParticipant);
				$match->setStartDate(new \DateTime());
				$match->setCup($groupRound->getCup());
				$match->setRound($groupRound);
				$this->matchRepository->add($match);
			}
		}
			// intresting: $groupRound->addMatch($match) ist not needed
		return $groupRound;
	}
	
	/**
	 * getTeamPairs
	 * 
	 * @param \Doctrine\Common\Collections\Collection $teams
	 * @return array
	 */
	protected function getTeamPairs(\Doctrine\Common\Collections\Collection $teams) {
		$pairs = array();
		for ($k = 0; $k < sizeof($teams); $k++) {
			for ($i = $k+1; $i < sizeof($teams); $i++) {
				$pair = array('teamOne' => $teams[$k], 'teamTwo' => $teams[$i]);
				$pairs[] = $pair;
			}
		}
		return $pairs;
	}
	
}
?>
