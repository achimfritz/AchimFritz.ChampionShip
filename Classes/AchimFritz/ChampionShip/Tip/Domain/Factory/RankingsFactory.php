<?php
namespace AchimFritz\ChampionShip\Tip\Domain\Factory;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Tip\Domain\Model\Ranking;
use AchimFritz\ChampionShip\Tip\Domain\Model\TipGroup;
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
	 * @param QueryResult<\AchimFritz\ChampionShip\Competition\Domain\Model\Match>
	 * @param TipGroup $tipGroup
	 * @return \Doctrine\Common\Collections\ArrayCollection
	 */
	public function create(QueryResult $matches, TipGroup $tipGroup = NULL) {
		$rankings = new ArrayCollection;
		if (count($matches) === 0) {
			return $rankings;
		}
		$identifiers = array();
		foreach ($matches AS $match) {
			$identifiers[] = "'" . $this->persistenceManager->getIdentifierByObject($match) . "'";
		}
		$where = 'tip.generalMatch IN (' . implode(',', $identifiers) . ')';
		$dql = 'SELECT user,sum(tip.points) AS points, count(tip) AS cnt 
			FROM \AchimFritz\ChampionShip\Domain\Model\User user 
			JOIN user.tips tip 
			WHERE ' . $where . ' GROUP BY user HAVING points > 0 ORDER BY points DESC';
		if ($tipGroup !== NULL) {
			$identifier = "'" . $this->persistenceManager->getIdentifierByObject($tipGroup) . "'";
			$where .= ' AND tipGroup = ' . $identifier;
			$dql = 'SELECT user,sum(tip.points) AS points, count(tip) AS cnt 
				FROM \AchimFritz\ChampionShip\Domain\Model\User user 
				JOIN user.tips tip 
				JOIN user.tipGroups tipGroup
				WHERE ' . $where . ' GROUP BY user ORDER BY points DESC';
		}
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
			$ranking->setCountOfTips($item['cnt']);
			$rankings->add($ranking);
			$rank++;
		}
		return $rankings;
	}
}
?>
