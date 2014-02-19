<?php
namespace AchimFritz\ChampionShip\Domain\Factory;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Domain\Model\User;
use AchimFritz\ChampionShip\Domain\Model\Registration;
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
	 * @var \TYPO3\Flow\Security\Cryptography\HashService
	 * @Flow\Inject
	 */
	protected $hashService;

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

	/**
	 * createFromRegistration 
	 * 
	 * @param Registration $registration 
	 * @return User $user
	 */
	public function createFromRegistration(Registration $registration) {
		$password = $registration->getPassword();
		$identifier = $registration->getUsername();
		$email = $registration->getEmail();
		$user = new User();
		$user->setEmail($email);
		#$user->setHmac($hmac);
		#$account = $this->accountFactory->createAccountWithPassword($identifier, $password, array('AchimFritz.ChampionShip:InRegistration'), 'HmacProvicer');
		$account = $this->accountFactory->createAccountWithPassword($identifier, $password, array('AchimFritz.ChampionShip:User'));
		$user->setAccount($account);
		return $user;
	}


}

?>
