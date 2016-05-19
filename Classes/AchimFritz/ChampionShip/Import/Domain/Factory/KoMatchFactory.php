<?php
namespace AchimFritz\ChampionShip\Import\Domain\Factory;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip.Import".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Competition\Domain\Model\KoMatch;
use AchimFritz\ChampionShip\Competition\Domain\Model\CrossGroupMatch;
use AchimFritz\ChampionShip\Competition\Domain\Model\TeamsOfTwoMatchesMatch;
use AchimFritz\ChampionShip\Competition\Domain\Model\Result;
use AchimFritz\ChampionShip\Competition\Domain\Model\GroupRound;
use AchimFritz\ChampionShip\Competition\Domain\Model\KoRound;
use AchimFritz\ChampionShip\Competition\Domain\Model\Cup;
use AchimFritz\ChampionShip\Import\Domain\Model\Match;

/**
 * KoMatchFactory
 *
 * @Flow\Scope("singleton")
 */
class KoMatchFactory {

   /**
    * @Flow\Inject
    * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\KoMatchRepository
    */
   protected $koMatchRepository;

   /**
    * @Flow\Inject
    * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\GroupRoundRepository
    */
   protected $groupRoundRepository;

   /**
    * createFromMatch
    * 
    * @param \AchimFritz\ChampionShip\Import\Domain\Model\Match $match
    * @param \AchimFritz\ChampionShip\Competition\Domain\Model\Cup $cup
    * @param \AchimFritz\ChampionShip\Competition\Domain\Model\KoRound $koRound
    * @return KoMatch $koMatch
    */
   public function createFromKoMatch(Match $match, Cup $cup, KoRound $koRound) {
		if ($match->getRoundType() == 2 AND count($cup->getTeams()) == 32) {
			// wm achtelfinale
			$koMatch = $this->createCrossGroupMatch($match, $cup);
		} elseif ($match->getRoundType() == 3 AND count($cup->getTeams()) == 16) {
			// em viertelfinale
			$koMatch = $this->createCrossGroupMatch($match, $cup);
		} else {
			$koMatch = $this->createTeamsOfTwoMatchesMatch($match, $cup);
		}
		$koMatch->setCup($cup);
		$koMatch->setName($match->getName());
		$startDate = new \DateTime();
		$startDate->setTimestamp($match->getStartDate());
		$koMatch->setStartDate($startDate);
		$koMatch->setRound($koRound);
		$this->koMatchRepository->update($koMatch);
		return $koMatch;
	}

	/**
	 * createCrossGroupMatch 
	 * 
	 * @param Match $match 
	 * @param Cup $cup 
	 * @return CrossGroupMatch
	 */
	protected function createCrossGroupMatch(Match $match, Cup $cup) {
		$koMatch = $this->koMatchRepository->findOneByNameAndCup($match->getName(), $cup);
		if (!$koMatch instanceof KoMatch) {
			$koMatch = new CrossGroupMatch();
			$this->koMatchRepository->add($koMatch);
		}
		$home = $match->getHomeTeam();
		$rank = substr($home, 0 , 1);
		$groupName = substr($home, 1 , 1);
		$group = $this->groupRoundRepository->findOneByName($groupName);
		if (!$group instanceof GroupRound) {
			throw new \Exception('no such groupRound' . $groupName, 1389637579);
		}
		$koMatch->setHostGroupRound($group);
		$koMatch->setHostGroupRank($rank);
		$guest = $match->getGuestTeam();
		$rank = substr($guest, 0 , 1);
		$groupName = substr($guest, 1 , 1);
		$group = $this->groupRoundRepository->findOneByName($groupName);
		if (!$group instanceof GroupRound) {
			throw new \Exception('no such groupRound ' . $groupName, 1389637580);
		}
		$koMatch->setGuestGroupRound($group);
		$koMatch->setGuestGroupRank($rank);
		return $koMatch;
	}

	/**
	 * createTeamsOfTwoMatchesMatch 
	 * 
	 * @param Match $match 
	 * @param Cup $cup 
	 * @return TeamsOfTwoMatchesMatch
	 */
	protected function createTeamsOfTwoMatchesMatch(Match $importMatch, Cup $cup) {
		$koMatch = $this->koMatchRepository->findOneByNameAndCup($importMatch->getName(), $cup);
		if (!$koMatch instanceof KoMatch) {
			$koMatch = new TeamsOfTwoMatchesMatch();
			$this->koMatchRepository->add($koMatch);
		}
		// home
		$home = $importMatch->getHomeTeam();
		$winnerOrLooser = substr($home, 0 , 1);
		if ($winnerOrLooser !== 'W' AND $winnerOrLooser !== 'L') {
			throw new \Exception('unknown home winnerOrLooser ' . $winnerOrLooser, 1389637583);
		}
		$matchName = substr($home, 1);
		$match = $this->koMatchRepository->findOneByName($matchName);
		if (!$match instanceof KoMatch) {
			throw new \Exception('no such KoMatch ' . $matchName, 1389637581);
		}
		if ($winnerOrLooser === 'W') {
			$koMatch->setHostMatchIsWinner(TRUE);
		} else {
			$koMatch->setHostMatchIsWinner(FALSE);
		}
		$koMatch->setHostMatch($match);

		// guest
		$guest = $importMatch->getGuestTeam();
		$winnerOrLooser = substr($guest, 0 , 1);
		if ($winnerOrLooser !== 'W' AND $winnerOrLooser !== 'L') {
			throw new \Exception('unknown guest winnerOrLooser ' . $winnerOrLooser, 1389637583);
		}
		$matchName = substr($guest, 1);
		$match = $this->koMatchRepository->findOneByName($matchName);
		if (!$match instanceof KoMatch) {
			throw new \Exception('no such KoMatch ' . $matchName, 1389637582);
		}
		if ($winnerOrLooser === 'W') {
			$koMatch->setGuestMatchIsWinner(TRUE);
		} else {
			$koMatch->setGuestMatchIsWinner(FALSE);
		}
		$koMatch->setGuestMatch($match);
		return $koMatch;
	}


   /**
    * createFromMatch
    * 
    * @param AchimFritz\ChampionShip\Import\Domain\Model\Match $match 
    * @param AchimFritz\ChampionShip\Competition\Domain\Model\Cup $cup 
    * @param array $teams
    * @param AchimFritz\ChampionShip\Competition\Domain\Model\KoRound $koRound
    * @return KoMatch $koMatch
    */
   public function createFromMatch(Match $match, array $teams, Cup $cup, KoRound $koRound) {
		$koMatch = $this->koMatchRepository->findByTwoTeamsAndCup(
			$teams[$match->getHomeTeam()],
			$teams[$match->getGuestTeam()],
			$cup
		)->getFirst();
		if (!$koMatch instanceof KoMatch) {
			$koMatch = new KoMatch();
			$this->koMatchRepository->add($koMatch);
		}
		$koMatch->setName($match->getName());
		$koMatch->setHostTeam($teams[$match->getHomeTeam()]);
		$koMatch->setGuestTeam($teams[$match->getGuestTeam()]);
		$koMatch->setCup($cup);
		$startDate = new \DateTime();
		$startDate->setTimestamp($match->getStartDate());
		$koMatch->setStartDate($startDate);
		$koMatch->setRound($koRound);
		if ((int)$match->getHomeGoals() === $match->getHomeGoals() AND (int)$match->getGuestGoals() === $match->getGuestGoals()) {
			$result = new Result();
			$result->setHostTeamGoals((int)$match->getHomeGoals());
			$result->setGuestTeamGoals((int)$match->getGuestGoals());
			$koMatch->setResult($result);
		}
		$this->koMatchRepository->update($koMatch);
		return $koMatch;
   }

}

?>
