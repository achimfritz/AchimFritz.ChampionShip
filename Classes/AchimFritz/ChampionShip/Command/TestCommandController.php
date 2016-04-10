<?php
namespace AchimFritz\ChampionShip\Command;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use \AchimFritz\ChampionShip\Competition\Domain\Model\KoMatch;
use \AchimFritz\ChampionShip\Competition\Domain\Model\Result;
use \AchimFritz\ChampionShip\Competition\Domain\Model\TeamsOfTwoMatchesMatch;

/**
 * Point Command
 *
 * @Flow\Scope("singleton")
 */
class TestCommandController extends \TYPO3\Flow\Cli\CommandController {

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\Persistence\PersistenceManagerInterface
	 */
	protected $persistenceManager;

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\CupRepository
	 */
	protected $cupRepository;
	
	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\KoMatchRepository
	 */
	protected $matchRepository;
	
	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\TeamsOfTwoMatchesMatchRepository
	 */
	protected $teamsOfTwoMatchesMatchRepository;

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\TeamRepository
	 */
	protected $teamRepository;

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\RoundRepository
	 */
	protected $roundRepository;

	/**
	 * koMatchCommand
	 * 
	 * @return void
	 */
	public function cupCommand() {
		$hf1 = $this->matchRepository->findOneByName('test1Match');
		#$l = $this->teamsOfTwoMatchesMatchRepository->findOneByHostMatch($hf1);
		#$this->outputLine('found?: ' . get_class($l));
		#$l = $this->teamsOfTwoMatchesMatchRepository->findOneByGuestMatch($hf1);
		#$l = $this->teamsOfTwoMatchesMatchRepository->findOneByGuestMatchAndWinner($hf1, TRUE);
		#$this->outputLine('found?: ' . get_class($l));

		$hf1->getResult()->setHostTeamGoals(0);
		$hf1->getResult()->setGuestTeamGoals(1);
		$this->matchRepository->update($hf1);
		$looserTeam = $hf1->getLooserTeam();
		$this->outputLine('looser: ' . $looserTeam->getName());
		//$hf2 = $this->matchRepository->findOneByName('test2Match');
	}

	/**
	 * koMatchCommand
	 * 
	 * @return void
	 */
	public function koMatchCommand() {
		$t1 = $this->teamRepository->findOneByName('Deutschland');
		$t2 = $this->teamRepository->findOneByName('Holland');
		$t3 = $this->teamRepository->findOneByName('Belgien');
		$t4 = $this->teamRepository->findOneByName('England');
		$cup = $this->cupRepository->findOneByName('test');

		$round = $this->roundRepository->findOneByName('aa');

		$hf1 = new KoMatch();
		$r1 = new Result();
		$r1->setHostTeamGoals(2);
		$r1->setGuestTeamGoals(0);
		$hf1->setResult($r1);
		$hf1->setHostTeam($t1);
		$hf1->setGuestTeam($t2);

		$hf1->setCup($cup);
		$hf1->setStartDate(new \DateTime());
		$hf1->setRound($round);

		$hf2 = new KoMatch();
		$r2 = new Result();
		$r2->setHostTeamGoals(2);
		$r2->setGuestTeamGoals(0);
		$hf2->setResult($r2);
		$hf2->setHostTeam($t3);
		$hf2->setGuestTeam($t4);
		$hf2->setCup($cup);
		$hf2->setStartDate(new \DateTime());
		$hf2->setRound($round);
		$hf2->setName('foobar');


		$l = new TeamsOfTwoMatchesMatch();
		$l->setHostMatch($hf1);
		$l->setHostMatchIsWinner(FALSE);
		$l->setGuestMatch($hf2);
		$l->setGuestMatchIsWinner(FALSE);
		$l->setCup($cup);
		$l->setStartDate(new \DateTime());
		$l->setRound($round);
		$this->matchRepository->add($hf1);
		$this->matchRepository->add($hf2);
		$this->matchRepository->add($l);
		$this->persistenceManager->persistAll();
		$this->matchRepository->update($hf1);
		$this->matchRepository->update($hf2);
		var_dump($l->getHostTeam()->getName());
		var_dump($l->getGuestTeam()->getName());

		$this->outputLine('count: '. count($this->matchRepository->findByName('foobar')));
		$this->matchRepository->remove($hf1);
		$this->matchRepository->remove($hf2);
		$this->matchRepository->remove($l);
		$this->persistenceManager->persistAll();
	}

}

?>
