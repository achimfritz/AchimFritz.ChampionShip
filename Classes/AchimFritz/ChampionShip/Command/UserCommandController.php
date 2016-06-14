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
	 * @var \AchimFritz\ChampionShip\User\Domain\Factory\UserFactory
	 * @Flow\Inject
	 */
	protected $userFactory;

	/**
	 * @var \AchimFritz\ChampionShip\User\Domain\Repository\TipGroupRepository
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
	 * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\CupRepository
	 */
	protected $cupRepository;

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Service\NotificationService
	 */
	protected $notificationService;

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Tip\Domain\Repository\TipRepository
	 */
	protected $tipRepository;

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

	// Fr. 9.00 Uhr

	/**
	 * @return void
	 */
	public function enableAllUserCommand() {
		$users = $this->userRepository->findAll();
		foreach ($users as $user) {
			$user->setDisabled(FALSE);
			$this->userRepository->update($user);
		}
	}

	/**
	 * @return void
	 */
	public function disableInactiveUserInCurrentCupCommand() {
		$cup = $this->cupRepository->findOneRecent();
		$users = $this->userRepository->findAll();
		foreach ($users as $user) {
			$tips = $this->tipRepository->findByUserInCupWithResult($user, $cup);
			if (count($tips) === 0) {
				$user->setDisabled(TRUE);
				$this->userRepository->update($user);
			} else {
				$user->setDisabled(FALSE);
				$this->userRepository->update($user);
			}
			$this->outputLine(count($tips) . ' - ' . $user->getDisplayName());
		}
	}

}
