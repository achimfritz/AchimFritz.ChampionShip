<?php
namespace AchimFritz\ChampionShip\User\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\User\Domain\Model\ForgotPasswordRequest;
use AchimFritz\ChampionShip\Generic\Controller\AbstractActionController;

class ForgotPasswordRequestController extends AbstractActionController
{

    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\User\Domain\Repository\ForgotPasswordRequestRepository
     */
    protected $forgotPasswordRequestRepository;

    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\User\Domain\Service\ForgotPasswordRequestService
     */
    protected $forgotPasswordService;

    /**
     * @var string
     */
    protected $resourceArgumentName = 'forgotPasswordRequest';

    /**
     * @return void
     */
    public function listAction()
    {
        $this->view->assign('forgotPasswordRequests', $this->forgotPasswordRequestRepository->findAll());
    }

    /**
     * @param \AchimFritz\ChampionShip\User\Domain\Model\ForgotPasswordRequest $forgotPasswordRequest
     * @return void
     */
    public function showAction(ForgotPasswordRequest $forgotPasswordRequest)
    {
        $this->view->assign('forgotPasswordRequest', $forgotPasswordRequest);
    }

    /**
     * @param \AchimFritz\ChampionShip\User\Domain\Model\ForgotPasswordRequest $forgotPasswordRequest
     * @return void
     */
    public function createAction(ForgotPasswordRequest $forgotPasswordRequest)
    {
        $forgotPasswordRequest = $this->forgotPasswordService->finish($forgotPasswordRequest, $this->request);
        $this->addOkMessage('forgotPasswordRequest created');
        $this->redirectHome();
    }

    /**
     * @param \AchimFritz\ChampionShip\User\Domain\Model\ForgotPasswordRequest $forgotPasswordRequest
     * @return void
     */
    public function updateAction(ForgotPasswordRequest $forgotPasswordRequest)
    {
        $this->forgotPasswordRequestRepository->update($forgotPasswordRequest);
        $this->addFlashMessage('Updated the forgot password request.');
        $this->redirect('list');
    }

    /**
     * @param \AchimFritz\ChampionShip\User\Domain\Model\ForgotPasswordRequest $forgotPasswordRequest
     * @return void
     */
    public function deleteAction(ForgotPasswordRequest $forgotPasswordRequest)
    {
        $this->forgotPasswordRequestRepository->remove($forgotPasswordRequest);
        $this->addFlashMessage('Deleted a forgot password request.');
        $this->redirect('list');
    }
}
