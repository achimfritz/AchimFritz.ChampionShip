<?php
namespace AchimFritz\ChampionShip\Import\Domain\Factory;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip.Import".*
 *                                                                        *
 *                                                                        */

use Neos\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Domain\Model\User;
use AchimFritz\ChampionShip\Domain\Model\TipGroup;

/**
 * UserFactory
 *
 * @Flow\Scope("singleton")
 */
class UserFactory
{

   /**
    * @Flow\Inject
    * @var \AchimFritz\ChampionShip\User\Domain\Repository\UserRepository
    */
    protected $userRepository;

    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\User\Domain\Repository\TipGroupRepository
     */
    protected $tipGroupRepository;

    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\User\Domain\Factory\UserFactory
     */
    protected $userFactory;

    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\Import\Domain\Factory\UserMapperInterface
     */
    protected $userMapper;

    /**
     * createFromUser
     *
     * @param \AchimFritz\ChampionShip\Import\Domain\Model\User $user
     * @param \AchimFritz\ChampionShip\Domain\Model\User $user
     */
    public function createFromUser(\AchimFritz\ChampionShip\Import\Domain\Model\User $user)
    {
        $this->userMapper->ignoredUsers($user);
        $name = $this->userMapper->mapName($user->getName(), $user->getEmail());
        $email = $this->userMapper->mapEmail($user->getEmail(), $user->getName());
        $pUser = $this->userRepository->findOneByIdentifierAndEmail($name, $email);
        if (!$pUser instanceof User) {
            $byName = $this->userRepository->findOneByAccountIdentifier($name);
            if ($byName instanceof User) {
                throw new \Exception('byName found: ' . $email . ' - ' . $name, 1391870466);
            }
            $pUser = $this->userFactory->create($email, $name);
            $this->userRepository->add($pUser);
        }
        if ($user->getGroups() != '') {
            $groups = explode(',', $user->getGroups());
            $i = 0;
            foreach ($groups as $group) {
                $tipGroup = $this->tipGroupRepository->findOneByName($group);
                if (!$tipGroup instanceof TipGroup) {
                    $tipGroup = new TipGroup();
                    $tipGroup->setName($group);
                    $this->tipGroupRepository->add($tipGroup);
                }
                if (!$pUser->getTipGroup() instanceof TipGroup) {
                    $pUser->setTipGroup($tipGroup);
                }
                if ($pUser->hasTipGroup($tipGroup) === false) {
                    $pUser->addTipGroup($tipGroup);
                }
            }
        } else {
            throw new \Exception('no tipgroup for ' . $name, 1398789359);
        }
        $this->userRepository->update($pUser);
        return $pUser;
    }
}
