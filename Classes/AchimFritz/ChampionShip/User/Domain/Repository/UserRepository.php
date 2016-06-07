<?php
namespace AchimFritz\ChampionShip\User\Domain\Repository;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use AchimFritz\ChampionShip\User\Domain\Model\User;
use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\User\Domain\Model\TipGroup;

/**
 * A repository for Users
 *
 * @Flow\Scope("singleton")
 */
class UserRepository extends \TYPO3\Flow\Persistence\Repository {

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\Security\AccountRepository
	 */
	protected $accountRepository;

	/**
	 * findOneByUsername 
	 * 
	 * @param string $username 
	 * @return User|NULL
	 */
	public function findOneByUsername($username) {
		return $this->findOneByAccountIdentifier($username);
	}

	/**
	 * @param \Doctrine\Common\Collections\Collection $tipGroups
	 * @return \TYPO3\Flow\Persistence\QueryResultInterface
	 */
	public function findInTipGroups(\Doctrine\Common\Collections\Collection $tipGroups) {
		$identifiers = array();
		foreach ($tipGroups as $tipGroup) {
			$identifiers[] = $this->persistenceManager->getIdentifierByObject($tipGroup);
		}
		$query = $this->createQuery();
		return $query->matching(
			$query->in('tipGroup', $identifiers)
		)->execute();
	}

	/**
	 * findOneByAccountIdentifier
	 * 
	 * @param string $username 
	 * @return User|NULL
	 */
	public function findOneByAccountIdentifier($accountIdentifier) {
		$query = $this->createQuery();
		return $query->matching(
					$query->equals('account.accountIdentifier', $accountIdentifier)
				)
			->execute()->getFirst();
	}

	/**
	 * findOneByIdentifierAndEmail 
	 * 
	 * @param string $identifier 
	 * @param string $email 
	 * @return Uesr|NULL
	 */
	public function findOneByIdentifierAndEmail($identifier, $email) {
		$query = $this->createQuery();
		return $query->matching(
				$query->logicalAnd(
					$query->equals('account.accountIdentifier', $identifier),
					$query->equals('email', $email)
					)
				)
			->execute()->getFirst();
	}

	/**
	 * findInTipGroup 
	 * 
	 * @param TipGroup $tipGroup 
	 * @return \TYPO3\Flow\Persistence\QueryResultInterface
	 */
	public function findInTipGroup(TipGroup $tipGroup) {
		$query = $this->createQuery();
		return $query->matching(
			$query->contains('tipGroups', $tipGroup)
		)->execute();
	}

	/**
	 * @param User $user
	 * @return void
	 */
	public function updateSecurityChecked(User $user) {
		$this->persistenceManager->update($user);
	}


}
?>
