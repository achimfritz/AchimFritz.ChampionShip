<?php
namespace AchimFritz\ChampionShip\Import\Command;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

/**
 * Point Command
 *
 * @Flow\Scope("singleton")
 */
class ImportCommandController extends \TYPO3\Flow\Cli\CommandController {
	
	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\Property\PropertyMapper
	 */
	protected $propertyMapper;

	/**
	 * @var \TYPO3\Flow\Persistence\PersistenceManagerInterface
	 * @Flow\Inject
	 */
	protected $persistenceManager;

	/**
	 * @var AchimFritz\ChampionShip\Import\Domain\Factory\UserFactory
	 * @Flow\Inject
	 */
	protected $userFactory;

	/**
	 * @var AchimFritz\ChampionShip\Import\Domain\Factory\TipFactory
	 * @Flow\Inject
	 */
	protected $tipFactory;
	
   /**
    * @var AchimFritz\ChampionShip\Import\Domain\Factory\GroupRoundFactory
    * @Flow\Inject
    */
   protected $groupRoundFactory;

   /**
    * @var AchimFritz\ChampionShip\Import\Domain\Factory\KoRoundFactory
    * @Flow\Inject
    */
   protected $koRoundFactory;

   /**
    * @var AchimFritz\ChampionShip\Import\Domain\Factory\GroupMatchFactory
    * @Flow\Inject
    */
   protected $groupMatchFactory;

   /**
    * @var AchimFritz\ChampionShip\Import\Domain\Factory\KoMatchFactory
    * @Flow\Inject
    */
   protected $koMatchFactory;

   /**
    * @var AchimFritz\ChampionShip\Import\Domain\Factory\CupFactory
    * @Flow\Inject
    */
   protected $cupFactory;

   /**
    * @var AchimFritz\ChampionShip\Import\Domain\Factory\TeamFactory
    * @Flow\Inject
    */
   protected $teamFactory;

	/**
	 * teamCommand($name)
	 * 
	 * name is a resource name like
	 * AchimFritz.ChampionShip.AchimFritz/Private/foo.json
	 *
	 * @param string $name
	 * @return void
	 */
	public function teamCommand($name) {
		$resource = 'resource://' . $name;
		if (!file_exists($resource)) {
			$this->outputLine('no such resource ' . $resource);
			$this->quit();
		}
		$content = file_get_contents($resource);
		$lines = explode("\n", $content);
		foreach ($lines AS $line) {
			$json = json_decode($line, TRUE);
			if ($json !== NULL) {
				$team = $this->propertyMapper->convert($json['team'], 'AchimFritz\ChampionShip\Import\Domain\Model\Team');
				try {
					$pTeam = $this->teamFactory->createFromTeam($team);
					$this->outputLine('OK ' . $pTeam->getName());
				} catch (\Exception $e) {
					$this->outputLine('ERROR ' . $e->getMessage());
				} 
			}
		}
	}

	/**
	 * komatchCommand($name)
	 * 
	 * name is a resource name like
	 * AchimFritz.ChampionShip.AchimFritz/Private/foo.json
	 * 
	 * @param string $name
	 * @return void
	 */
	public function komatchCommand($name) {
		$resource = 'resource://' . $name;
		if (!file_exists($resource)) {
			$this->outputLine('no such resource ' . $resource);
			$this->quit();
		}
		$content = file_get_contents($resource);
		$lines = explode("\n", $content);
		foreach ($lines AS $line) {
			$json = json_decode($line, TRUE);
			if ($json !== NULL) {
				$match = $this->propertyMapper->convert($json['match'], 'AchimFritz\ChampionShip\Import\Domain\Model\Match');
				try {
					$cup = $this->cupFactory->createFromMatch($match, array());

					$koRound = $this->koRoundFactory->createFromMatch($match, array(), $cup);
					$koMatch = $this->koMatchFactory->createFromKoMatch($match, $cup, $koRound);
					$this->persistenceManager->persistAll();
					$this->outputLine('OK ' . $match->getHomeTeam() . ' - ' . $match->getGuestTeam());
				} catch (\Exception $e) {
					$this->outputLine('ERROR (' . $match->getCupName() . ')' . $e->getMessage());
				}
			}
		}
	}

	/**
	 * matchCommand($name)
	 * 
	 * name is a resource name like
	 * AchimFritz.ChampionShip.AchimFritz/Private/foo.json
	 * 
	 * @param string $name
	 * @return void
	 */
	public function matchCommand($name) {
		$resource = 'resource://' . $name;
		if (!file_exists($resource)) {
			$this->outputLine('no such resource ' . $resource);
			$this->quit();
		}
		$content = file_get_contents($resource);
		$lines = explode("\n", $content);
		foreach ($lines AS $line) {
			$json = json_decode($line, TRUE);
			if ($json !== NULL) {
				$match = $this->propertyMapper->convert($json['match'], 'AchimFritz\ChampionShip\Import\Domain\Model\Match');
				try {
					$teams = $this->teamFactory->createFromMatch($match);
					$cup = $this->cupFactory->createFromMatch($match, $teams);
					$this->persistenceManager->persistAll();
					if ($match->getRoundType() == 1 OR $match->getRoundType() == 0) {
						$groupRound = $this->groupRoundFactory->createFromMatch($match, $teams, $cup);
						$groupMatch = $this->groupMatchFactory->createFromMatch($match, $teams, $cup, $groupRound);
					} else {
						$koRound = $this->koRoundFactory->createFromMatch($match, $teams, $cup);
						$koMatch = $this->koMatchFactory->createFromMatch($match, $teams, $cup, $koRound);
					}
					$this->persistenceManager->persistAll();
					$this->outputLine('OK ' . $match->getHomeTeam() . ' - ' . $match->getGuestTeam());
				} catch (\Exception $e) {
					$this->outputLine('ERROR (' . $match->getCupName() . ')' . $e->getMessage());
				}
			}
		}
	}

	/**
	 * tipCommand($name)
	 * 
	 * name is a resource name like
	 * AchimFritz.ChampionShip.AchimFritz/Private/foo.json
	 * 
	 * @param string $name
	 * @return void
	 */
	public function tipCommand($name) {
		$resource = 'resource://' . $name;
		if (!file_exists($resource)) {
			$this->outputLine('no such resource ' . $resource);
			$this->quit();
		}
		$content = file_get_contents($resource);
		$lines = explode("\n", $content);
		foreach ($lines AS $line) {
			$json = json_decode($line, TRUE);
			if ($json !== NULL) {
				$tip = $this->propertyMapper->convert($json['tip'], 'AchimFritz\ChampionShip\Import\Domain\Model\Tip');
				try {
					$newTip = $this->tipFactory->createFromTip($tip);
					$this->outputLine('OK ' . $tip->getHomeTeam() . ' - ' . $tip->getGuestTeam() . ' - ' . $newTip->getUser()->getDisplayName());
				} catch (\Exception $e) {
					$this->outputLine('ERROR ' . $e->getMessage());
				}
			}
		}
	}

	/**
	 * userCommand($name)
	 * 
	 * name is a resource name like
	 * AchimFritz.ChampionShip.AchimFritz/Private/foo.json
	 * 
	 * @param string $name
	 * @return void
	 */
	public function userCommand($name) {
		$resource = 'resource://' . $name;
		if (!file_exists($resource)) {
			$this->outputLine('no such resource ' . $resource);
			$this->quit();
		}
		$content = file_get_contents($resource);
		$lines = explode("\n", $content);
		foreach ($lines AS $line) {
			$json = json_decode($line, TRUE);
			if ($json !== NULL) {
				$importUser = $this->propertyMapper->convert($json['user'], 'AchimFritz\ChampionShip\Import\Domain\Model\User');
				try {
					$pUser = NULL;
					$pUser = $this->userFactory->createFromUser($importUser);
					$this->persistenceManager->persistAll();
					$this->outputLine('OK, user updated ' . $pUser->getName() . ' ' . $pUser->getEmail() . ' ' . $pUser->getTipGroup()->getName());
				} catch (\Exception $e) {
					$this->outputLine('ERROR ' . $e->getMessage());
				}
			}
		}
	}
}

?>
