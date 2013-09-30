<?php
namespace AchimFritz\ChampionShip\Command;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Party\Domain\Model\ElectronicAddress;
use TYPO3\Party\Domain\Model\Person;
use AchimFritz\ChampionShip\Domain\Model\User;
use AchimFritz\ChampionShip\Domain\Model\TipGroup;

/**
 * The User Command Controller Service
 *
 * @Flow\Scope("singleton")
 */
class UserCommandController extends \TYPO3\Flow\Cli\CommandController {

	/**
	 * @var \AchimFritz\ChampionShip\Domain\Factory\TipFactory
	 * @Flow\Inject
	 */
	protected $tipFactory;

	/**
	 * @var \AchimFritz\ChampionShip\Domain\Factory\UserFactory
	 * @Flow\Inject
	 */
	protected $userFactory;

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
	 * @param string $username 
	 * @param string $nickName
	 * @param string $tipGroupName
	 * @return void
	 */
	public function createUserCommand($username, $nickName, $tipGroupName) {
		try {
			$tipGroup = $this->tipGroupRepository->findOneByName($tipGroupName);
			if (!$tipGroup instanceof TipGroup) {
				$tipGroup = new TipGroup();
				$tipGroup->setName($tipGroupName);
				$this->tipGroupRepository->add($tipGroup);
			}
			$user = $this->userFactory->create($username, $nickName, $tipGroup);
			$tipGroup->addUser($user);
			$this->tipGroupRepository->update($tipGroup);
			$this->outputLine('user created: ' . $username);
		} catch (\Exception $e) {
			$this->outputLine('ERROR ' . $e->getMessage());
		}
	}

	/**
	 * initTipCommand ($username)
	 * 
	 * @param string $username 
	 * @return void
	 */
	public function initTipCommand($username) {
		$user = $this->userRepository->findOneByUsername($username);
		if ($user instanceof User) {
			$this->outputLine($user->getName());
			$tips = $this->tipFactory->initTips($user);
			$this->outputLine('has ' . count($tips) . ' tips');
		} else {
			$this->outputline('no user found with username ' . $username);
		}
	}

}

?>
