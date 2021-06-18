<?php
namespace AchimFritz\ChampionShip\Tip\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use Neos\Flow\Annotations as Flow;
use \AchimFritz\ChampionShip\Tip\Domain\Model\Tip;

/**
 * Standard controller for the AchimFritz.ChampionShip package
 *
 * @Flow\Scope("singleton")
 */
class TipController extends AbstractActionController
{

    /**
     * @var \AchimFritz\ChampionShip\Tip\Domain\Repository\TipRepository
     * @Flow\Inject
     */
    protected $tipRepository;

    /**
     * @var string
     */
    protected $resourceArgumentName = 'tip';

    /**
     * Allow modification of resources in updateAction()
     *
     * @return void
     */
    public function initializeUpdateAction()
    {
        parent::initializeUpdateAction();
        // allow tip.result
        $propertyMappingConfiguration = $this->arguments[$this->resourceArgumentName]->getPropertyMappingConfiguration();
        $propertyMappingConfiguration->forProperty('result');
        $sub = $propertyMappingConfiguration->getConfigurationFor('result');
        $sub->setTypeConverterOption('Neos\Flow\Property\TypeConverter\PersistentObjectConverter', \Neos\Flow\Property\TypeConverter\PersistentObjectConverter::CONFIGURATION_CREATION_ALLOWED, true);
        $sub->allowAllProperties();
    }

    /**
     * Index action
     *
     * @param \AchimFritz\ChampionShip\Tip\Domain\Model\Tip $tip
     * @return void
     */
    public function showAction(Tip $tip)
    {
        $this->view->assign('tip', $tip);
        $match = $tip->getMatch();
        $tips = $this->tipRepository->findByGeneralMatch($match);
        $this->view->assign('tips', $tips);
        $this->view->assign('cup', $match->getCup());
    }

    /**
     * updateAction
     *
     * @param \AchimFritz\ChampionShip\Tip\Domain\Model\Tip $tip
     * @return void
     */
    public function updateAction(Tip $tip)
    {
        $this->updateTip($tip);
        $this->redirect('index', null, null, array('tip' => $tip));
    }

    /**
     * UpdateTip
     *
     * @param \AchimFritz\ChampionShip\Tip\Domain\Model\Tip
     * @return void
     */
    public function updateTip(Tip $tip)
    {
        try {
            $this->tipRepository->update($tip);
            $this->persistenceManager->persistAll();
            $this->addOkMessage($tip->getResult()->getHostTeamGoals() . ':' . $tip->getResult()->getGuestTeamGoals());
        } catch (\Exception $e) {
            $this->addErrorMessage('cannot update tip');
            $this->handleException($e);
        }
    }
}
