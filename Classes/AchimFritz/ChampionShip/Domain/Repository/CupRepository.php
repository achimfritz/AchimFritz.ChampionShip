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


	/**
	 * Removes an object from this repository.
	 *
	 * @param object $object The object to remove
	 * @return void
	 * @throws \TYPO3\Flow\Persistence\Exception\IllegalObjectTypeException
	 * @api
	 */
	public function remove($object) {
		$matches = $this->matchRepository->findByCup($object);
		foreach ($matches AS $match) {
			$this->matchRepository->remove($match);
		}
		$rounds = $this->roundRepository->findByCup($object);
		foreach ($rounds AS $round) {
			$this->roundRepository->remove($round);
		}
		return parent::remove($object);
	}

}
?>
