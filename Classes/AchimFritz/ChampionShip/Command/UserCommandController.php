<?php
namespace AchimFritz\ChampionShip\Command;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\User\Domain\Model\User;
use AchimFritz\ChampionShip\User\Domain\Model\TipGroup;

/**
 * The User Command Controller Service
 *
 * @Flow\Scope("singleton")
 */
class UserCommandController extends \TYPO3\Flow\Cli\CommandController {

	/**
	 * @var \AchimFritz\ChampionShip\Tip\Domain\Factory\TipFactory
	 * @Flow\Inject
	 */
	protected $tipFactory;

	/**
	 * @var \AchimFritz\ChampionShip\User\Domain\Factory\UserFactory
	 * @Flow\Inject
	 */
	protected $userFactory;

	/**
	 * @var \AchimFritz\ChampionShip\Tip\Domain\Repository\TipGroupRepository
	 * @Flow\Inject
	 */
	protected $tipGroupRepository;

	/**
	 * @var \AchimFritz\ChampionShip\User\Domain\Repository\UserRepository
	 * @Flow\Inject
	 */
	protected $userRepository;

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Service\NotificationService
	 */
	protected $notificationService;

	/**
	 * inviteUserCommand 
	 * 
	 * @param string username
	 * @param boolean $sendMail 
	 * @return void
	 */
	public function inviteOneUserCommand($username, $sendMail = FALSE) {
		$user = $this->userRepository->findOneByUsername($username);
		if (!$user instanceof User) {
			$this->outputLine('user not found ' . $username);
		}
		$this->outputLine('will sent invitation mail to ' . $user->getEmail());
		if ($sendMail === TRUE) {
			$this->notificationService->inviteUser($user);
			$this->outputLine('sending ' . $user->getEmail());
		}
	}

	/**
	 * inviteUserCommand 
	 * 
	 * @param boolean $sendMail 
	 * @return void
	 */
	public function inviteUserCommand($sendMail = FALSE) {
		$users = $this->userRepository->findAll();
		$this->outputLine('will sent invitation mail to ' . count($users) . ' users');
		if ($sendMail === TRUE) {
			foreach ($users as $user) {
				$this->notificationService->inviteUser($user);
				$this->outputLine('sending ' . $user->getEmail());
			}
		}
	}

	/**
	 * initUsersForRecentCupCommand 
	 * 
	 * @return void
	 */
	public function initUsersForRecentCupCommand() {
		$users = $this->userRepository->findAll();
		try {
			foreach ($users as $user) {
				$this->tipFactory->initUserTipsForCurrentCup($user);
				$this->outputLine('OK ' . $user->getUsername());
			}
		} catch (\Exception $e) {
			$this->outputLine('ERROR ' . $e->getMessage());
		}
	}

	/**
	 * Create a new user
	 *
	 * @param string $username 
	 * @param string $email
	 * @param string $tipGroupName
	 * @return void
	 */
	public function createUserCommand($username, $email, $tipGroupName) {
		try {
			$tipGroup = $this->tipGroupRepository->findOneByName($tipGroupName);
			if (!$tipGroup instanceof TipGroup) {
				$tipGroup = new TipGroup();
				$tipGroup->setName($tipGroupName);
				$this->tipGroupRepository->add($tipGroup);
			}
			$user = $this->userFactory->create($username, $email);
			$user->setTipGroup($tipGroup);
			$this->userRepository->add($user);
			$this->outputLine('user created: ' . $username);
		} catch (\Exception $e) {
			$this->outputLine('ERROR ' . $e->getMessage());
		}
	}

}

?>
