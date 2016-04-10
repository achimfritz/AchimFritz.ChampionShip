<?php
namespace AchimFritz\ChampionShip\Competition\Domain\Policy\GroupTable;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Competition\Domain\Model\GroupTableRow;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * AbstractPointEqualityPolicy
 *
 *	@Flow\Scope("singleton")
 */
abstract class AbstractPointEqualityPolicy {

	/**
	 * groupTableFactory 
	 * 
	 * @var \AchimFritz\ChampionShip\Competition\Domain\Factory\GroupTableFactory
	 * @Flow\Inject
	 */
	protected $groupTableFactory;

	/**
	 * @var \AchimFritz\ChampionShip\Competition\Domain\Policy\GroupTable\DefaultPolicy
	 * @Flow\Inject
	 */
	protected $defaultPolicy;

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\Log\SystemLoggerInterface
	 */
	protected $systemLogger;

   /**
    * rowsAreEquay 
    * 
    * @param GroupTableRow $rowOne 
    * @param GroupTableRow $rowTwo 
    * @return boolean
    */
   abstract protected function rowsAreEqual(GroupTableRow $rowOne, GroupTableRow $rowTwo);

	/**
	 * getPolicyName 
	 * 
	 * @return string
	 */
	abstract protected function getPolicyName();

	/**
	 * addMessage 
	 * 
	 * @param string $message 
	 * @return void
	 */
	protected function addMessage($message) {
		$this->systemLogger->log($this->getPolicyName() . ': ' . $message, LOG_INFO);
	}

   /**
    * getMatchOfTwoRows
    * 
    * @param \Doctrine\Common\Collections\Collection $matches 
    * @param GroupTableRow $row 
    * @param GroupTableRow $next 
    * @return void
    */
   protected function getMatchOfTwoRows(\Doctrine\Common\Collections\Collection $matches, GroupTableRow $row, GroupTableRow $next) {
      $teamOne = $row->getTeam();
      $teamTwo = $next->getTeam();
      foreach ($matches AS $match) {
         if ($match->getTwoTeamsPlayThisMatch($teamOne, $teamTwo)) {
				return $match;
         }
      }
   }

	/**
	 * getRelevantMatches
	 * 
	 * @param array<GroupTableRow> $rows 
	 * @param Collection<GroupMatch> $matches
	 * @return ArrayCollection<GroupMatch> $relavant
	 */
	protected function getRelevantMatches(array $rows, Collection $matches) {
		$relevant = new ArrayCollection();
		if (count($rows) == 2) {
			$match = $this->getMatchOfTwoRows($matches, $rows[0], $rows[1]);
			$relevant->add($match);
		} elseif (count($rows) === 3) {
			$match = $this->getMatchOfTwoRows($matches, $rows[0], $rows[1]);
			$relevant->add($match);
			$match = $this->getMatchOfTwoRows($matches, $rows[0], $rows[2]);
			$relevant->add($match);
			$match = $this->getMatchOfTwoRows($matches, $rows[1], $rows[2]);
			$relevant->add($match);
		} 
		return $relevant;
	}

	/**
	 * pointEquality 
	 * 
	 * @param array<GroupTableRow> $rows 
	 * @param Collection<GroupMatch> $matches
	 * @return ArrayCollection<GroupMatch> $relavant
	 */
	protected function pointEquality(array $rows, Collection $matches) {
		$this->addMessage('checking ' . count($rows) . ' teams');
		$first = $rows[0];
		$startRank = $first->getRank() - 1;
		foreach ($rows AS $row) {
			$this->addMessage($row->getTeam()->getName() . ' with rank ' . $row->getRank());
		}
		$relevant = $this->getRelevantMatches($rows, $matches);
		$groupTableRows = $this->groupTableFactory->createTable($relevant);
		$groupTableRows = $this->defaultPolicy->updateTable($groupTableRows);
		foreach($rows AS $row) {
			$teamName = $row->getTeam()->getName();
			$new = $groupTableRows[$teamName];
			$rank = $startRank + $new->getRank();
			$this->addMessage('new rank of ' . $teamName . ' is ' . $rank);
			$row->setRank($rank);
		}
	}

   /**
    * updateTable
    * 
    * @param array<\AchimFritz\ChampionShip\Competition\Domain\Model\GroupTableRow>
	 * @param \Doctrine\Common\Collections\Collection<\AchimFritz\ChampionShip\Competition\Domain\Model\GroupMatch>
    * @return array<\AchimFritz\ChampionShip\Competition\Domain\Model\GroupTableRow>
    */
   public function updateTable(array $rows, Collection $matches) {
		$first = $matches->first();
		$this->addMessage('updateTable ' . $first->getRound()->getName() . ' ' . $first->getCup()->getName());
		$rows = $this->defaultPolicy->updateTable($rows, $matches);
		// numeric array
      $res = array();
		$new = array();
      foreach ($rows AS $row) {
         $res[] = $row;
      }
      for ($i = 0; $i < sizeof($res) - 1; $i++) {
         $row = $res[$i];
         $next = $res[$i+1];
         if ($this->rowsAreEqual($row, $next)) {
            if ($i + 2 < sizeof($res)) {
               $overNext = $res[$i+2];
               if ($this->rowsAreEqual($next, $overNext)) {
						$this->pointEquality(array($row, $next, $overNext), $matches);
						//finish
						$i++;
               } else {
						$this->pointEquality(array($row, $next), $matches);
					}
            } else {
					$this->pointEquality(array($row, $next), $matches);
				}
         }
      }
		// assoc array
		$new = array();
		foreach ($res as $row) {
			$name = $row->getTeam()->getName();
			$new[$name] = $row;
		}
      return $new;
   }
}
?>
