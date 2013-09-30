<?php
namespace AchimFritz\ChampionShip\Domain\Repository;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Security\Account;

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
		$account = $this->accountRepository->findOneByAccountIdentifier($username);
		if ($account instanceof Account) {
			return $this->findOneByAccount($account);
		}
		return NULL;
	}


}
?>
