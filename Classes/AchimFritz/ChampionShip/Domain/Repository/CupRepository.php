<?php
namespace AchimFritz\ChampionShip\Domain\Repository;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

/**
 * A repository for Cups
 *
 * @Flow\Scope("singleton")
 */
class CupRepository extends \TYPO3\Flow\Persistence\Repository {

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\MatchRepository
	 */
	protected $matchRepository;

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\RoundRepository
	 */
	protected $roundRepository;

   /**
    * findOneActual 
    * 
    * @return \AchimFritz\ChampionShip\Domain\Model\Cup
    */
	public function findOneRecent() {
		$query = $this->createQuery();
		$query->setOrderings(array('startDate' => \TYPO3\Flow\Persistence\QueryInterface::ORDER_DESCENDING));
		return $query->execute()->getFirst();
	}

}
?>
