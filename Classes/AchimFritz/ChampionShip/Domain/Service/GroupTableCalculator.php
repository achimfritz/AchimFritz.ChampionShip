<?php
namespace AchimFritz\ChampionShip\Domain\Service;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Domain\Model\GroupTableRow;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * A GroupTableCalculator
 *
 * @Flow\Scope("singleton")
 */
class GroupTableCalculator {

	/**
	 * groupTableFactory 
	 * 
	 * @var \AchimFritz\ChampionShip\Domain\Factory\GroupTableFactory
	 * @Flow\Inject
	 */
	protected $groupTableFactory;
	
	/**
	 * updateGroup
	 * 
	 * @param \Doctrine\Common\Collections\Collection<\AchimFritz\ChampionShip\Domain\Model\GroupMatch>
	 * @return \Doctrine\Common\Collections\Collection<\AchimFritz\ChampionShip\Domain\Model\GroupTableRows>
	 */
	public function getGroupTableRows(Collection $matches) {
		$first = $matches->first();
		$cup = $first->getCup();
		$name = $cup->getGroupTablePolicy();
		$rankingPolicy = new $name;
      $groupTableRows = new ArrayCollection();
      $rows = $this->groupTableFactory->createTable($matches);
		$rows = $rankingPolicy->updateTable($rows, $matches);
      foreach ($rows AS $row) {
         $groupTableRows->add($row);
      }
      return $groupTableRows;
	}

}
?>
