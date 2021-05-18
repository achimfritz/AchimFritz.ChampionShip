<?php
namespace AchimFritz\ChampionShip\User\Domain\Validator;

use AchimFritz\ChampionShip\User\Domain\Model\RegistrationRequest;

/**
 * RegistrationRequestValidator
 *
 * @package
 * @version $id$
 * @copyright 1997-2007 Lightwerk
 * @author Achim Fritz <lw@lightwerk.com>
 * @license
 */
class RegistrationRequestValidator extends \Neos\Flow\Validation\Validator\GenericObjectValidator
{

    /**
     * Checks if the concatenated person name has at least one character.
     *
     * Any errors can be retrieved through the getErrors() method.
     *
     * @param mixed $value The value that should be validated
     * @return void
     */
    public function isValid($value)
    {
        if ($value instanceof RegistrationRequest) {
            if (strcmp($value->getNewPassword(), $value->getNewPasswordRepeat()) !== 0) {
                $this->addError('Passwords missmatch.', 1268676866);
            }
        }
    }
}
