<?php
namespace AchimFritz\ChampionShip\Competition\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * A Team
 *
 * @Flow\Entity
 */
class Team {

	/**
	 * The name
	 * @var string
	 * @Flow\Identity
	 * @Flow\Validate(type="NotEmpty")
	 */
	protected $name;

	/**
	 * @var string
	 */
	protected $nameDe = '';

	/**
	 * @var string
	 */
	protected $nameEn = '';

	/**
	 * @var string
	 */
	protected $nameLocal = '';

	/**
	 * @var string
	 */
	protected $iso2 = '';

	/**
	 * @var string
	 */
	protected $iso3 = '';

	/**
	 * Get the Team's name
	 *
	 * @return string The Team's name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @return string
	 */
	public function getIso3Upper() {
		return strtoupper($this->getIso3());
	}

	/**
	 * Sets this Team's name
	 *
	 * @param string $name The Team's name
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * getNameEn 
	 * 
	 * @return string nameEn
	 */
	public function getNameEn() {
		return $this->nameEn;
	}

	/**
	 * setNameEn
	 * 
	 * @param string $nameEn
	 * @return void
	 */
	public function setNameEn($nameEn) {
		$this->nameEn = $nameEn;
	}

	/**
	 * getNameDe 
	 * 
	 * @return string nameDe
	 */
	public function getNameDe() {
		return $this->nameDe;
	}

	/**
	 * setNameDe
	 * 
	 * @param string $nameDe
	 * @return void
	 */
	public function setNameDe($nameDe) {
		$this->nameDe = $nameDe;
	}

	/**
	 * getNameLocal 
	 * 
	 * @return string nameLocal
	 */
	public function getNameLocal() {
		return $this->nameLocal;
	}

	/**
	 * setNameLocal
	 * 
	 * @param string $nameLocal
	 * @return void
	 */
	public function setNameLocal($nameLocal) {
		$this->nameLocal = $nameLocal;
	}

	/**
	 * getIso2 
	 * 
	 * @return string iso2
	 */
	public function getIso2() {
		return $this->iso2;
	}

	/**
	 * setIso2
	 * 
	 * @param string $iso2
	 * @return void
	 */
	public function setIso2($iso2) {
		$this->iso2 = $iso2;
	}

	/**
	 * getIso3 
	 * 
	 * @return string iso3
	 */
	public function getIso3() {
		return $this->iso3;
	}

	/**
	 * setIso3
	 * 
	 * @param string $iso3
	 * @return void
	 */
	public function setIso3($iso3) {
		$this->iso3 = $iso3;
	}

}
?>
