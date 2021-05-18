<?php
namespace AchimFritz\ChampionShip\Tip\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use Neos\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\User\Domain\Model\TipGroup;
use AchimFritz\ChampionShip\User\Domain\Model\User;

class AbstractTipGroupResultsController extends AbstractTipGroupController
{


    /**
     * @var \AchimFritz\ChampionShip\Tip\Domain\Factory\TipGroupResultMatrixFactory
     * @Flow\Inject
     */
    protected $matrixFactory;

    /**
     * @var string
     */
    protected $resourceArgumentName = 'tipGroup';

    /**
     * listAction
     *
     * @return void
     */
    public function listAction()
    {
        if ($this->user instanceof User) {
            $tipGroup = $this->user->getTipGroup();
        } else {
            // admin only
            $tipGroup = $this->tipGroupRepository->findAll()->getFirst();
        }
        if ($tipGroup instanceof TipGroup) {
            $this->forward('show', null, null, array('tipGroup' => $tipGroup, 'cup' => $this->cup));
        } else {
            $this->addErrorMessage('no tipGroup found');
        }
    }

    /**
     * showAction
     *
     * @param \AchimFritz\ChampionShip\User\Domain\Model\TipGroup $tipGroup
     * @return void
     */
    public function showAction(TipGroup $tipGroup)
    {
        $users = $this->userRepository->findInTipGroup($tipGroup);
        $matches = $this->matchRepository->findByCup($this->cup);
        $matrix = $this->matrixFactory->create($users, $matches);
        $this->view->assign('matrix', $matrix);
        $this->view->assign('tipGroup', $tipGroup);
    }
}
