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
	 * @var \AchimFritz\ChampionShip\Domain\Repository\TipGroupRepository
	 * @Flow\Inject
	 */
	protected $tipGroupRepository;

	/**
	 * @var \AchimFritz\ChampionShip\Domain\Repository\UserRepository
	 * @Flow\Inject
	 */
	protected $userRepository;

	/**
	 * Create a new user
	 *
	 * @param string $username The username of the user to be created.
	 * @return User $user
	 */
	public function create($username, $nickName, $tipGroupName) {
		$roles = 'AchimFritz.ChampionShip:User';
		$authenticationProvider = 'DefaultProvider';
		$password = $username;
		$email = $username;
		$account = $this->accountRepository->findByAccountIdentifierAndAuthenticationProviderName($username, $authenticationProvider);
		if ($account instanceof \TYPO3\Flow\Security\Account) {
			throw new Exception('user already exists  ' . $username, 1380121115);
		}

		$person = new Person();
		$electronicAddress = new ElectronicAddress();
		$electronicAddress->setIdentifier($email);
		$electronicAddress->setType(ElectronicAddress::TYPE_EMAIL);
		$person->setPrimaryElectronicAddress($electronicAddress);
		$person->setName(new PersonName('', '', '', '', $nickName));
		$this->partyRepository->add($person);

		$tipGroup = $this->tipGroupRepository->findOneByName($tipGroupName);
		if (!$tipGroup instanceof TipGroup) {
			$tipGroup = new TipGroup();
			$tipGroup->setName($tipGroupName);
			$this->tipGroupRepository->add($tipGroup);
		}

		$account = $this->accountFactory->createAccountWithPassword($username, $password, explode(',', $roles), $authenticationProvider);
		$account->setParty($person);
		$this->accountRepository->add($account);

		$user = new User();
		$user->setAccount($account);
		$user->setMainTipGroup($tipGroup);
		$tipGroup->addUser($user);
		$this->tipGroupRepository->update($tipGroup);
		$this->userRepository->add($user);
		return $user;
	}


}

?>
