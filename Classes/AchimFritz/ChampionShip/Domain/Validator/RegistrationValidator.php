<?php
namespace AchimFritz\ChampionShip\Domain\Validator;

use AchimFritz\ChampionShip\Domain\Model\Registration;

/**
 * RegistrationValidator 
 * 
 * @package 
 * @version $id$
 * @copyright 1997-2007 Lightwerk
 * @author Achim Fritz <lw@lightwerk.com> 
 * @license 
 */
class RegistrationValidator extends \TYPO3\Flow\Validation\Validator\GenericObjectValidator {

	/**
	 * Checks if the concatenated person name has at least one character.
	 *
	 * Any errors can be retrieved through the getErrors() method.
	 *
	 * @param mixed $value The value that should be validated
	 * @return void
	 */
	public function isValid($value) {
		if ($value instanceof Registration) {
			if (strcmp($value->getPassword(), $value->getPasswordRepeat()) !== 0) {
				$this->addError('Passwords missmatch.', 1268676866);
			}
		}
	}

}
?>
