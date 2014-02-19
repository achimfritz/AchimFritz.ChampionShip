<?php
namespace AchimFritz\ChampionShip\Domain\Service;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Domain\Model\PasswordRequest;

/**
 * Team controller for the AchimFritz.ChampionShip package 
 *
 * @Flow\Scope("singleton")
 */
class PasswordRequestService {

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\PasswordRequestRepository
	 */
	protected $passwordRequestRepository;

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\UserRepository
	 */
	protected $userRepository;

	/**
	 * @var \TYPO3\Flow\Security\Cryptography\HashService
	 * @Flow\Inject
	 */
	protected $hashService;


	public function handle(PasswordRequest $passwordRequest) {
		// TODO only email ...
		$email = $passwordRequest->getEmail();
		$users = $this->userRepository->findByEmail($email);
		foreach ($users AS $user) {
			$newRequest = new PasswordRequest();
			$newRequest->setEmail($email);
			$newRequest->setUser($user);
			$newRequest->setCreationDate(new \DateTime());
			$string = $email . $user->getAccount()->getAccountIdentifier();
			$hmac = $this->hashService->generateHmac($string);
			$newRequest->setHmac($hmac);
			// Test if exists? (tstamp im hmac...)
			$this->passwordRequestRepository->add($newRequest);
		}
	}

}

?>
