<?php
namespace AchimFritz\ChampionShip\Domain\Factory;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Domain\Model\Ranking;
use Doctrine\Common\Collections\ArrayCollection;
use TYPO3\Flow\Persistence\Doctrine\QueryResult;

/**
 * A RankingsFactory
 *
 * @Flow\Scope("singleton")
 */
class RankingsFactory {

	/**
	 * @Flow\Inject
	 * @var \Doctrine\Common\Persistence\ObjectManager
	 */
	protected $entityManager;

	/**
	 * @var \TYPO3\Flow\Persistence\PersistenceManagerInterface
	 * @Flow\Inject
	 */
	protected $persistenceManager;

	/**
	 * create 
	 * 
	 * @param QueryResult<\AchimFritz\ChampionShip\Domain\Model\Match>
	 * @return \Doctrine\Common\Collections\ArrayCollection
	 */
	public function create(QueryResult $matches) {
		$rankings = new ArrayCollection;
		$identifiers = array();
		foreach ($matches AS $match) {
			$identifiers[] = "'" . $this->persistenceManager->getIdentifierByObject($match) . "'";
		}
		$dql = 'SELECT user,sum(tip.points) AS points FROM \AchimFritz\ChampionShip\Domain\Model\User user JOIN user.tips tip WITH tip.generalMatch IN (' . implode(',', $identifiers) . ') WHERE tip.points > 0 GROUP BY user ORDER BY points DESC';
		$query = $this->entityManager->createQuery($dql);
		$result = $query->execute();
		$rank = 1;
		foreach ($result AS $item) {
			$user = $item[0];
			$points = $item['points'];
			$ranking = new Ranking();
			$ranking->setUser($user);
			$ranking->setPoints($points);
			$ranking->setRank($rank);
			$rankings->add($ranking);
			$rank++;
		}
		return $rankings;
	}
}
?>
