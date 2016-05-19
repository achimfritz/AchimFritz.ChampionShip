<?php
namespace AchimFritz\ChampionShip\Import\Domain\Factory;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip.Import".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Domain\Model\User;

/**
 * UserMapper
 *
 * @Flow\Scope("singleton")
 */
class UserMapper implements UserMapperInterface {

	/**
	 * ignoredUsers 
	 * 
	 * @param User $user 
	 * @return void
	 * @throws Exception
	 */
	public function ignoredUsers(\AchimFritz\ChampionShip\Import\Domain\Model\User $user) {
	}

	/**
	 * mapName 
	 * 
	 * @param string $name 
	 * @param string $email
	 * @return string
	 */
	public function mapName($name, $email = '') {
		$name = strtolower(trim($name));
		return $name;
	}

	/**
	 * mapEmail 
	 * 
	 * @param string $email 
	 * @param string $name 
	 * @return string
	 */
	public function mapEmail($email, $name = '') {
		$email = strtolower(trim($email));
		return $email;
	}

}

?>
