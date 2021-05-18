<?php
namespace AchimFritz\ChampionShip\User\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use AchimFritz\ChampionShip\Generic\Controller\AbstractActionController;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Security\Account;
use AchimFritz\ChampionShip\User\Domain\Model\TipGroup;
use AchimFritz\ChampionShip\User\Domain\Model\User;
use AchimFritz\ChampionShip\User\Domain\Model\RegistrationRequest;

/**
 * Team controller for the AchimFritz.ChampionShip package
 *
 * @Flow\Scope("singleton")
 */
class RegistrationRequestController extends AbstractActionController
{

    /**
     * @var string
     */
    protected $resourceArgumentName = 'registrationRequest';

    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\User\Domain\Repository\RegistrationRequestRepository
     */
    protected $registrationRequestRepository;

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
     * @var \AchimFritz\ChampionShip\Service\NotificationService
     */
    protected $notificationService;

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
     * @return void
     */
    public function listAction()
    {
        $this->view->assign('registrationRequests', $this->registrationRequestRepository->findAll());
    }

    /**
     * @param \AchimFritz\ChampionShip\User\Domain\Model\RegistrationRequest $registrationRequest
     * @return void
     */
    public function showAction(RegistrationRequest $registrationRequest)
    {
        $user = $this->userRepository->findOneByUsername($registrationRequest->getUsername());
        $tipGroup = $this->tipGroupRepository->findOneByName($registrationRequest->getTipGroupName());
        // warnings for admin
        if (!$this->user instanceof User && $this->account instanceof Account) {
            if ($user instanceof User) {
                $this->addWarningMessage('user exisists with username ' . $registrationRequest->getUsername());
            }
            if (!$tipGroup instanceof TipGroup) {
                $this->addWarningMessage('no tipGroup with name ' . $registrationRequest->getTipGroupName());
            }
            if (!$user instanceof User && $tipGroup instanceof TipGroup) {
                $this->addOkMessage('user can be created');
            }
        }
        $this->view->assign('tipGroup', $tipGroup);
        $this->view->assign('tipGroups', $this->tipGroupRepository->findAll());
        $this->view->assign('user', $user);
        $this->view->assign('registrationRequest', $registrationRequest);
    }

    /**
     * @param \AchimFritz\ChampionShip\User\Domain\Model\RegistrationRequest $registrationRequest
     * @return void
     */
    public function createAction(RegistrationRequest $registrationRequest)
    {
        try {
            $this->registrationRequestRepository->add($registrationRequest);
            $this->persistenceManager->persistAll();
            $this->addOkMessage('registrationRequest created');
            $this->notificationService->registrationStarted($registrationRequest);
        } catch (\Exception $e) {
            $this->addErrorMessage('cannot create registrationRequest');
            $this->handleException($e);
            $this->redirect('index');
        }
        $this->redirectHome();
    }

    /**
     * @param \AchimFritz\ChampionShip\User\Domain\Model\RegistrationRequest $registrationRequest
     * @return void
     */
    public function updateAction(RegistrationRequest $registrationRequest)
    {
        try {
            $this->registrationRequestRepository->update($registrationRequest);
            $this->persistenceManager->persistAll();
            $this->addOkMessage('registrationRequest updated');
        } catch (\Exception $e) {
            $this->addErrorMessage('cannot update registrationRequest');
            $this->handleException($e);
        }
        $this->redirect('index', null, null, array('registrationRequest' => $registrationRequest));
    }

    /**
     * @param \AchimFritz\ChampionShip\User\Domain\Model\RegistrationRequest $registrationRequest
     * @return void
     */
    public function deleteAction(RegistrationRequest $registrationRequest)
    {
        try {
            $this->registrationRequestRepository->remove($registrationRequest);
            $this->persistenceManager->persistAll();
            $this->addOkMessage('registrationRequest deleted');
        } catch (\Exception $e) {
            $this->addErrorMessage('cannot delete registrationRequest');
            $this->handleException($e);
        }
        $this->redirect('index');
    }
}
