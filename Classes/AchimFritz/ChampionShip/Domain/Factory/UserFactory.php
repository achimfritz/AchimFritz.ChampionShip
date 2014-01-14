<?php
namespace AchimFritz\ChampionShip\Domain\Factory;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Party\Domain\Model\ElectronicAddress;
use TYPO3\Party\Domain\Model\PersonName;
use TYPO3\Party\Domain\Model\Person;
use AchimFritz\ChampionShip\Domain\Model\User;
use AchimFritz\ChampionShip\Domain\Model\TipGroup;

/**
 * The User Command Controller Service
 *
 * @Flow\Scope("singleton")
 */
class UserFactory {

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\Security\AccountRepository
	 */
	protected $accountRepository;

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Party\Domain\Repository\PartyRepository
	 */
	protected $partyRepository;

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\Security\AccountFactory
	 */
	protected $accountFactory;

	/**
	 * @var \AchimFritz\ChampionShip\Domain\Repository\UserRepository
	 * @Flow\Inject
	 */
	protected $userRepository;

	/**
	 * Create a new user
	 *
	 * @param string $email
	 * @param string $nickName
	 * @return User $user
	 */
	public function create($email, $nickName) {
		$roles = 'AchimFritz.ChampionShip:User';
		$authenticationProvider = 'DefaultProvider';
		$password = $email;
		$accountIdentifier = $nickName . '@' . $email;
		$account = $this->accountRepository->findByAccountIdentifierAndAuthenticationProviderName($accountIdentifier, $authenticationProvider);
		if ($account instanceof \TYPO3\Flow\Security\Account) {
			throw new Exception('user already exists  ' . $accountIdentifier, 1380121115);
		}

		$person = new Person();
		$electronicAddress = new ElectronicAddress();
		$electronicAddress->setIdentifier($email);
		$electronicAddress->setType(ElectronicAddress::TYPE_EMAIL);
		$person->setPrimaryElectronicAddress($electronicAddress);
		$person->setName(new PersonName('', '', '', '', $nickName));
		$this->partyRepository->add($person);

		$account = $this->accountFactory->createAccountWithPassword($accountIdentifier, $password, explode(',', $roles), $authenticationProvider);
		$account->setParty($person);
		$this->accountRepository->add($account);

		$user = new User();
		$user->setAccount($account);
		$this->userRepository->add($user);
		return $user;
	}


}

?>
