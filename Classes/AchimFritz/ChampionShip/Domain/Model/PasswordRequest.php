<?php
namespace AchimFritz\ChampionShip\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Flow\Entity
 */
class PasswordRequest extends AccountRequest {

	/**
	 * @var \AchimFritz\ChampionShip\Domain\Model\User
	 * @ORM\OneToOne
	 */
	protected $user = NULL;

	/**
	 * @return \AchimFritz\ChampionShip\Domain\Model\User
	 */
	public function getUser() {
		return $this->user;
	}

	/**
	 * @param \AchimFritz\ChampionShip\Domain\Model\User $user
	 * @return void
	 */
	public function setUser(User $user) {
		$this->user = $user;
	}

}
?>
