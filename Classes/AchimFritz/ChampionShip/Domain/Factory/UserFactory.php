<?php
namespace AchimFritz\ChampionShip\Domain\Factory;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Domain\Model\User;
use TYPO3\Flow\Security\AccountFactory;
/**
 * The User Command Controller Service
 *
 * @Flow\Scope("singleton")
 */
class UserFactory {

	/**
	 * @var \TYPO3\Flow\Security\AccountFactory
	 * @Flow\Inject
	 */
	protected $accountFactory;


	/**
	 * Create a new user
	 *
	 * @param string $email
	 * @param string $name
	 * @return User $user
	 */
	public function create($email, $name) {
		$password = $email;
		$identifier = $name; 
		$user = new User();
		$user->setEmail($email);
		$account = $this->accountFactory->createAccountWithPassword($identifier, $password, array('AchimFritz.ChampionShip:User'));
		$user->setAccount($account);
		return $user;
	}


}

?>
