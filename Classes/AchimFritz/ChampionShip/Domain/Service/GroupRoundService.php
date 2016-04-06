<?php
namespace AchimFritz\ChampionShip\Domain\Service;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Domain\Model\GroupTableRow;
use AchimFritz\ChampionShip\Domain\Model\MatchParticipant;
use AchimFritz\ChampionShip\Competition\Domain\Model\Match;
use AchimFritz\ChampionShip\Competition\Domain\Model\GroupRound;


/**
 * A GroupRoundService
 *
 * @Flow\Scope("singleton")
 */
class GroupRoundService {
	
	
   /**
    * @Flow\Inject
    * @var \AchimFritz\ChampionShip\Domain\Factory\GroupMatchFactory
    */
   protected $matchFactory;

	/**
	 * @var \AchimFritz\ChampionShip\Domain\Service\GroupTableCalculator
	 * @Flow\Inject
	 */
	protected $groupTableCalculator;
	
	/**
	 * updateGroupTable
	 * 
	 * @param \AchimFritz\ChampionShip\Domain\Model\GroupRound $groupRound
	 * @return \AchimFritz\ChampionShip\Domain\Model\GroupRound $groupRound
	 */
	public function updateGroupTable(GroupRound $groupRound) {
		$matches = $groupRound->getGeneralMatches();
		if (count($matches) > 0) {
			$groupTableRows = $this->groupTableCalculator->getGroupTableRows($matches);
			$groupRound->clearGroupTableRows();
			$groupRound->setGroupTableRows($groupTableRows);
		}
		return $groupRound;
	}
	
	/**
	 * createMatches
	 * 
	 * @param \AchimFritz\ChampionShip\Domain\Model\GroupRound $groupRound
	 * @return \AchimFritz\ChampionShip\Domain\Model\GroupRound $groupRound
	 */
	public function createMatches(GroupRound $groupRound) {
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
				$match = $this->matchFactory->createFromTeams($teamPair['teamOne'], $teamPair['teamTwo']);
				$match->setCup($groupRound->getCup());
				$match->setRound($groupRound);
				$groupRound->addGeneralMatch($match);
			}
		}
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
