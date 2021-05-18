<?php
namespace AchimFritz\ChampionShip\Tip\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Error\Message;
use Neos\Flow\Security\Account;
use \AchimFritz\ChampionShip\User\Domain\Model\User;

/**
 * Action controller for the AchimFritz.ChampionShip package
 *
 * @Flow\Scope("singleton")
 */
class AbstractActionController extends \AchimFritz\ChampionShip\Competition\Controller\AbstractActionController
{

    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\User\Domain\Repository\UserRepository
     */
    protected $userRepository;

    /**
     * @var \Neos\Flow\Security\Context
     * @Flow\Inject
     */
    protected $securityContext;

    /**
     * @var User
     */
    protected $user = null;

    /**
     * @var Account
     */
    protected $account = null;


    /**
     * initializeAction
     *
     * @return void
     */
    protected function initializeAction()
    {
        parent::initializeAction();
        $this->account = $this->securityContext->getAccount();
        if ($this->account) {
            $user = $this->userRepository->findOneByAccount($this->account);
            if ($user instanceof User) {
                $this->user = $user;
            }
        }
    }

    /**
     * handleException
     *
     * @param \Exception $e
     * @return void
     */
    protected function handleException(\Exception $e)
    {
        if ($this->user === null && $this->account !== null) {
            // must be an admin
            $this->addFlashMessage($e->getMessage(), get_class($e), Message::SEVERITY_ERROR, array(), $e->getCode());
        }
    }
}
