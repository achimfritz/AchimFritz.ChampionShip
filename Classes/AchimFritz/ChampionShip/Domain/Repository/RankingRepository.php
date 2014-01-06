<?php
namespace AchimFritz\ChampionShip\Domain\Repository;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Domain\Model\User;
use AchimFritz\ChampionShip\Domain\Model\Cup;
use AchimFritz\ChampionShip\Domain\Model\Ranking;
use TYPO3\Flow\Persistence\QueryInterface;

/**
 * RankingRepository
 *
 * @Flow\Scope("singleton")
 */
class RankingRepository extends \TYPO3\Flow\Persistence\Repository {

	/**
	 * @Flow\Inject
	 * @var \Doctrine\Common\Persistence\ObjectManager
	 */
	protected $entityManager;

	/**
	 * __construct 
	 * 
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
		$this->setDefaultOrderings(array('points' => QueryInterface::ORDER_DESCENDING));
	}
	/**
	 * findOneByUserInCup 
	 * 
	 * @param User $user 
	 * @param Cup $cup 
	 * @return Ranking|NULL
	 */
	public function findOneByUserInCup(User $user, Cup $cup) {
		$query = $this->createQuery();
		return $query->matching(
            $query->logicalAnd(
				$query->equals('user', $user),
				$query->equals('cup', $cup)
			)
		)
		->execute()->getFirst();
	}

	/**
	 * findAllGroupByUser 
	 * 
	 * @return \TYPO3\FLOW3\Persistence\QueryResultInterface
	 */
	public function findAllGroupByUser() {
		#$dql = 'SELECT ranking,sum(ranking.points) AS points, user FROM \AchimFritz\ChampionShip\Domain\Model\Ranking ranking JOIN \AchimFritz\ChampionShip\Domain\Model\User user WHERE 1=1 GROUP BY ranking.user';
		$dql = 'SELECT ranking,sum(ranking.points) AS points FROM \AchimFritz\ChampionShip\Domain\Model\Ranking ranking WHERE 1=1 GROUP BY ranking.user ORDER BY points DESC';
		#$dql = 'SELECT ranking,sum(ranking.points) AS points FROM \AchimFritz\ChampionShip\Domain\Model\Ranking ranking JOIN ranking.user WHERE 1=1 GROUP BY ranking.user';
		#$dql = 'SELECT ranking FROM \AchimFritz\ChampionShip\Domain\Model\Ranking ranking WHERE 1=1';
		$query = $this->entityManager->createQuery($dql);
		$result = $query->execute();
		foreach ($result AS $r) {
			#var_dump(count($r));
			$a = $r[0];
			#var_dump(get_class($a->getUser()));
			#var_dump($a->getUser()->getName());
			#var_dump(get_class($a));
		}
		return $result;
	}

}
?>
