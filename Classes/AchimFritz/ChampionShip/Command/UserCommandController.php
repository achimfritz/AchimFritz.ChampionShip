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

/**
 * The User Command Controller Service
 *
 * @Flow\Scope("singleton")
 */
class UserCommandController extends \TYPO3\Flow\Cli\CommandController {

	/**
	 * @var \AchimFritz\ChampionShip\Domain\Factory\UserFactory
	 * @Flow\Inject
	 */
	protected $userFactory;

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
			$user = $this->userFactory->create($username, $nickName, $tipGroupName);
			$this->outputLine('user created: ' . $username);
		} catch (\Exception $e) {
			$this->outputLine('ERROR ' . $e->getMessage());
		}
	}

}

?>
