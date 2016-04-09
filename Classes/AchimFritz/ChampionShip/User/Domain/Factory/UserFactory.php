<?php
namespace AchimFritz\ChampionShip\Domain\Factory;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Domain\Model\User;
use AchimFritz\ChampionShip\Domain\Model\TipGroup;
use TYPO3\Flow\Security\AccountFactory;
use AchimFritz\ChampionShip\Domain\Model\RegistrationRequest;
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
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\TipGroupRepository
	 */
	protected $tipGroupRepository;

	/**
	 * @var \AchimFritz\ChampionShip\Domain\Factory\TipFactory
	 * @Flow\Inject
	 */
	protected $tipFactory;

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
		// TODO in future: avoid incomplete cup
		$this->tipFactory->initUserTipsForCurrentCup($user);
		return $user;
	}

	/**
	 * createFromRegistrationRequest 
	 * 
	 * @param RegistrationRequest $registrationRequest 
	 * @return User
	 */
	public function createFromRegistrationRequest(RegistrationRequest $registrationRequest) {
		$tipGroup = $this->tipGroupRepository->findOneByName($registrationRequest->getTipGroupName());
		if (!$tipGroup instanceof TipGroup) {
			throw new Exception('no tipGroup found with name ' . $registrationRequest->getTipGroupName(), 1400686014);
		}
		$user = new User();
		$user->setEmail($registrationRequest->getEmail());
		$account = $this->accountFactory->createAccountWithPassword($registrationRequest->getUsername(), 'notBeUsed', array('AchimFritz.ChampionShip:User'));
		$account->setCredentialsSource($registrationRequest->getNewPassword());
		$user->setAccount($account);
		$user->setTipGroup($tipGroup);
		// TODO in future: avoid incomplete cup
		$this->tipFactory->initUserTipsForCurrentCup($user);
		return $user;
	}

}

?>
