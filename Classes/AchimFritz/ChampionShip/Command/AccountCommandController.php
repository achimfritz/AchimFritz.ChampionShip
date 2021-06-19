<?php
namespace AchimFritz\ChampionShip\Command;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use AchimFritz\ChampionShip\User\Domain\Repository\UserRepository;
use Neos\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\User\Domain\Model\User;
use AchimFritz\ChampionShip\User\Domain\Model\TipGroup;
use Neos\Flow\Security\AccountRepository;

/**
 * The User Command Controller Service
 *
 * @Flow\Scope("singleton")
 */
class AccountCommandController extends \Neos\Flow\Cli\CommandController
{

    /**
     * @var \Neos\Flow\Security\AccountRepository
     * @Flow\Inject
     */
    protected $accountRepository;

    /**
     * @var UserRepository
     * @Flow\Inject
     */
    protected $userRepository;

    /**
     * @var \Neos\Flow\Security\Cryptography\HashService
     * @Flow\Inject
     */
    protected $hashService;

    /**
     * @return void
     */
    public function listCommand()
    {
        $accounts = $this->accountRepository->findAll();
        foreach ($accounts as $account) {
            $user = $this->userRepository->findOneByAccountIdentifier($account->getAccountIdentifier());
            if ($user !== null) {
                $this->outputLine($account->getAccountIdentifier() . ' - ' . $user->getEmail());
            }
        }
    }

    public function updatePasswordCommand(string $accountIdentifier, string $password): int
    {
        $account = $this->accountRepository->findOneByAccountIdentifier($accountIdentifier);
        if ($account === null) {
            $this->outputLine('no such user');
            return 1;
        }
        $account->setCredentialsSource($this->hashService->hashPassword($password));
        $this->accountRepository->update($account);
        $this->outputLine($account->getAccountIdentifier());
        return 0;
    }
}
