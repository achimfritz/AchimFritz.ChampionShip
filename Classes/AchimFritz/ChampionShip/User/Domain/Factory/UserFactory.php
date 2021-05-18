<?php
namespace AchimFritz\ChampionShip\User\Domain\Factory;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use Neos\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\User\Domain\Model\User;
use AchimFritz\ChampionShip\User\Domain\Model\TipGroup;
use AchimFritz\ChampionShip\User\Domain\Model\RegistrationRequest;

/**
 * The User Command Controller Service
 *
 * @Flow\Scope("singleton")
 */
class UserFactory
{

    /**
     * @var \Neos\Flow\Security\AccountFactory
     * @Flow\Inject
     */
    protected $accountFactory;

    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\User\Domain\Repository\TipGroupRepository
     */
    protected $tipGroupRepository;

    /**
     * @param string $email
     * @param string $name
     * @return User $user
     */
    public function create($email, $name)
    {
        $password = $email;
        $identifier = $name;
        $user = new User();
        $user->setEmail($email);
        $account = $this->accountFactory->createAccountWithPassword($identifier, $password, array('AchimFritz.ChampionShip:User'));
        $user->setAccount($account);
        return $user;
    }

    /**
     * @param RegistrationRequest $registrationRequest
     * @return User
     */
    public function createFromRegistrationRequest(RegistrationRequest $registrationRequest)
    {
        $tipGroup = $this->tipGroupRepository->findOneByName($registrationRequest->getTipGroupName());
        if (!$tipGroup instanceof TipGroup) {
            throw new Exception('no tipGroup found with name ' . $registrationRequest->getTipGroupName(), 1400686014);
        }
        $user = new User();
        $user->setEmail($registrationRequest->getEmail());
        $account = $this->accountFactory->createAccountWithPassword($registrationRequest->getUsername(), 'notBeUsed', array('AchimFritz.ChampionShip:User'));
        $account->setCredentialsSource($registrationRequest->getNewPassword());
        $user->setAccount($account);
        $user->setTipGroup($tipGroup);
        return $user;
    }
}
