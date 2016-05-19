<?php
namespace AchimFritz\ChampionShip\Import\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip.Import".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * Team
 */
class Team {

	/**
	 * @var string
	 */
	protected $nameEn;

	/**
	 * @var string
	 */
	protected $nameDe;

	/**
	 * @var string
	 */
	protected $nameLocal;

	/**
	 * @var string
	 */
	protected $iso2;

	/**
	 * @var string
	 */
	protected $iso3;


	/**
	 * @return string
	 */
	public function getNameEn() {
		return $this->nameEn;
	}

	/**
	 * @param string $nameEn
	 * @return void
	 */
	public function setNameEn($nameEn) {
		$this->nameEn = $nameEn;
	}

	/**
	 * @return string
	 */
	public function getNameDe() {
		return $this->nameDe;
	}

	/**
	 * @param string $nameDe
	 * @return void
	 */
	public function setNameDe($nameDe) {
		$this->nameDe = $nameDe;
	}

	/**
	 * @return string
	 */
	public function getNameLocal() {
		return $this->nameLocal;
	}

	/**
	 * @param string $nameLocal
	 * @return void
	 */
	public function setNameLocal($nameLocal) {
		$this->nameLocal = $nameLocal;
	}

	/**
	 * @return string
	 */
	public function getIso2() {
		return $this->iso2;
	}

	/**
	 * @param string $iso2
	 * @return void
	 */
	public function setIso2($iso2) {
		$this->iso2 = $iso2;
	}

	/**
	 * @return string
	 */
	public function getIso3() {
		return $this->iso3;
	}

	/**
	 * @param string $iso3
	 * @return void
	 */
	public function setIso3($iso3) {
		$this->iso3 = $iso3;
	}

}
?>
