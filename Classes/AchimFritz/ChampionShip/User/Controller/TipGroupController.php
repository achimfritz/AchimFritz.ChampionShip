<?php
namespace AchimFritz\ChampionShip\User\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use AchimFritz\ChampionShip\Generic\Controller\AbstractActionController;
use Neos\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\User\Domain\Model\TipGroup;

class TipGroupController extends AbstractActionController
{

    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\User\Domain\Repository\TipGroupRepository
     */
    protected $tipGroupRepository;

    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\User\Domain\Repository\UserRepository
     */
    protected $userRepository;

    /**
     * @var string
     */
    protected $resourceArgumentName = 'tipGroup';

    /**
     * @return void
     */
    public function listAction()
    {
        $this->view->assign('tipGroups', $this->tipGroupRepository->findAll());
    }

    /**
     * @param \AchimFritz\ChampionShip\User\Domain\Model\TipGroup $tipGroup
     * @return void
     */
    public function showAction(TipGroup $tipGroup)
    {
        $this->view->assign('tipGroups', $this->tipGroupRepository->findAll());
        $this->view->assign('users', $this->userRepository->findInTipGroup($tipGroup));
        $this->view->assign('tipGroup', $tipGroup);
    }

    /**
     * @param \AchimFritz\ChampionShip\User\Domain\Model\TipGroup $tipGroup
     * @return void
     */
    public function createAction(TipGroup $tipGroup)
    {
        try {
            $this->tipGroupRepository->add($tipGroup);
            $this->persistenceManager->persistAll();
            $this->addOkMessage('tipGroup created');
        } catch (\Exception $e) {
            $this->addErrorMessage('cannot create tipGroup');
            $this->handleException($e);
        }
        $this->redirect('index', null, null, array('tipGroup' => $tipGroup));
    }

    /**
     * @param \AchimFritz\ChampionShip\User\Domain\Model\TipGroup $tipGroup
     * @return void
     */
    public function updateAction(TipGroup $tipGroup)
    {
        try {
            $this->tipGroupRepository->update($tipGroup);
            $this->persistenceManager->persistAll();
            $this->addOkMessage('tipGroup updated');
        } catch (\Exception $e) {
            $this->addErrorMessage('cannot update tipGroup');
            $this->handleException($e);
        }
        $this->redirect('index', null, null, array('tipGroup' => $tipGroup));
    }

    /**
     * @param \AchimFritz\ChampionShip\User\Domain\Model\TipGroup $tipGroup
     * @return void
     */
    public function deleteAction(TipGroup $tipGroup)
    {
        try {
            $this->tipGroupRepository->remove($tipGroup);
            $this->persistenceManager->persistAll();
            $this->addOkMessage('tipGroup deleted');
        } catch (\Exception $e) {
            $this->addErrorMessage('cannot delete tipGroup');
            $this->handleException($e);
        }
        $this->redirect('index');
    }
}
