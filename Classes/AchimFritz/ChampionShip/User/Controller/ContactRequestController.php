<?php
namespace AchimFritz\ChampionShip\User\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use AchimFritz\ChampionShip\Generic\Controller\AbstractActionController;
use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\User\Domain\Model\ContactRequest;

/**
 * Team controller for the AchimFritz.ChampionShip package
 *
 * @Flow\Scope("singleton")
 */
class ContactRequestController extends AbstractActionController
{

    /**
     * @var string
     */
    protected $resourceArgumentName = 'contactRequest';

    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\User\Domain\Repository\ContactRequestRepository
     */
    protected $contactRequestRepository;

    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\Service\NotificationService
     */
    protected $notificationService;

    /**
     * @return void
     */
    public function listAction()
    {
        $this->view->assign('contactRequests', $this->contactRequestRepository->findAll());
    }

    /**
     * @param \AchimFritz\ChampionShip\User\Domain\Model\ContactRequest $contactRequest
     * @return void
     */
    public function showAction(ContactRequest $contactRequest)
    {
        $this->view->assign('contactRequest', $contactRequest);
    }

    /**
     * @param \AchimFritz\ChampionShip\User\Domain\Model\ContactRequest $contactRequest
     * @return void
     */
    public function createAction(ContactRequest $contactRequest)
    {
        try {
            $this->contactRequestRepository->add($contactRequest);
            $this->persistenceManager->persistAll();
            $msg = $this->translator->translateById('contactRequest.created', array(), null, null, 'Main', 'AchimFritz.ChampionShip');
            $this->addOkMessage($msg);
            $this->notificationService->contactStarted($contactRequest);
        } catch (\Exception $e) {
            $this->addErrorMessage('cannot create contactRequest');
            $this->handleException($e);
        }
        $this->redirectHome();
    }

    /**
     * @param \AchimFritz\ChampionShip\User\Domain\Model\ContactRequest $contactRequest
     * @return void
     */
    public function updateAction(ContactRequest $contactRequest)
    {
        try {
            $this->contactRequestRepository->update($contactRequest);
            $this->persistenceManager->persistAll();
            $this->addOkMessage('contactRequest updated');
        } catch (\Exception $e) {
            $this->addErrorMessage('cannot update contactRequest');
            $this->handleException($e);
        }
        $this->redirect('index', null, null, array('contactRequest' => $contactRequest));
    }

    /**
     * @param \AchimFritz\ChampionShip\User\Domain\Model\ContactRequest $contactRequest
     * @return void
     */
    public function deleteAction(ContactRequest $contactRequest)
    {
        try {
            $this->contactRequestRepository->remove($contactRequest);
            $this->persistenceManager->persistAll();
            $this->addOkMessage('contactRequest deleted');
        } catch (\Exception $e) {
            $this->addErrorMessage('cannot delete contactRequest');
            $this->handleException($e);
        }
        $this->redirect('index');
    }
}
