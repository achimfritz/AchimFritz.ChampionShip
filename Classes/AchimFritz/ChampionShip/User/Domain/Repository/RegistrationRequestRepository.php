<?php
namespace AchimFritz\ChampionShip\User\Domain\Repository;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use Neos\Flow\Annotations as Flow;

/**
 * @Flow\Scope("singleton")
 */
class RegistrationRequestRepository extends \Neos\Flow\Persistence\Repository
{

    /**
     * @var \Neos\Flow\Security\Cryptography\HashService
     * @Flow\Inject
     */
    protected $hashService;

    /**
     * add
     *
     * @param mixed $object
     * @return void
     */
    public function add($object)
    {
        // hash password
        $password = $this->hashService->hashPassword($object->getNewPassword(), 'default');
        $object->setNewPassword($password);
        $object->setNewPasswordRepeat($password);
        parent::add($object);
    }
}
