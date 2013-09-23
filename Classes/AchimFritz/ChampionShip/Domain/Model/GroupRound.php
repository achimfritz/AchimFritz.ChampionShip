<?php
namespace AchimFritz\ChampionShip\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * A Round
 *
 * @Flow\Entity
 */
class GroupRound extends Round {

	/**
	 * The group table
	 * @var \Doctrine\Common\Collections\Collection<\AchimFritz\ChampionShip\Domain\Model\GroupTableRow>
	 * @ORM\OneToMany(mappedBy="groupRound", cascade={"all"})
	 * @ORM\OrderBy({"rank" = "ASC"})
	 */
	protected $groupTableRows;
	
	/**
	 * __construct
	 * 
	 * @return void
	 */
	public function __construct() {
      parent::__construct();
		$this->groupTableRows = new \Doctrine\Common\Collections\ArrayCollection();
	}
	
	/**
	 * getTeamByRank
	 * 
	 * @param integer $rank
	 * @return \AchimFritz\ChampionShip\Domain\Model\Team|NULL
	 */
	public function getTeamByRank($rank) {
		$groupTableRows = $this->getGroupTableRows();
		if (isset($groupTableRows[$rank-1])) {
			$row = $groupTableRows[$rank-1];
			return $row->getTeam();
		}
		return NULL;
	}
	
	
	/**
	 * getWinnerTeam
	 * 
	 * @return \AchimFritz\ChampionShip\Domain\Model\Team
	 */
	public function getWinnerTeam() {
		return $this->getTeamByRank(1);
	}
	
	/**
	 * getSecondTeam
	 * 
	 * @return \AchimFritz\ChampionShip\Domain\Model\Team
	 */
	public function getSecondTeam() {
		return $this->getTeamByRank(2);
	}
	
	/**
	 * Get the Group table's group table rows
	 *
	 * @return \AchimFritz\ChampionShip\Domain\Model\GroupTableRow The Group table's group table rows
	 */
	public function getGroupTableRows() {
		return $this->groupTableRows;
	}

	/**
	 * Sets this Group table's group table rows
	 *
	 * @param \Doctrine\Common\Collections\Collection<\AchimFritz\ChampionShip\Domain\Model\GroupTableRow>
	 * @return void
	 */
	public function setGroupTableRows(\Doctrine\Common\Collections\Collection $groupTableRows) {
		$this->groupTableRows = $groupTableRows;
	}
	
	/**
	 * clearGroupTableRows
	 * 
	 * @return void
	 */
	public function clearGroupTableRows() {
		$this->groupTableRows->clear();
	}
	
	/**
	 * removeGroupTableRow
	 * 
	 * @param \AchimFritz\ChampionShip\Domain\Model\GroupTableRow $groupTableRow
	 * @return void
	 */
	public function removeGroupTableRow(\AchimFritz\ChampionShip\Domain\Model\GroupTableRow $groupTableRow) {
		$this->groupTableRows->remove($groupTableRow);
	}
	
	/**
	 * Sets this Group table's group table rows
	 *
	 * @param \AchimFritz\ChampionShip\Domain\Model\GroupTableRow
	 * @return void
	 */
	public function addGroupTableRow(\AchimFritz\ChampionShip\Domain\Model\GroupTableRow $groupTableRow) {
		$this->groupTableRows->add($groupTableRow);
	}
	
}
?>
