<?php
namespace AchimFritz\ChampionShip\Tip\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use \AchimFritz\ChampionShip\Tip\Domain\Model\TipCup;

/**
 * Standard controller for the AchimFritz.ChampionShip package
 *
 * @Flow\Scope("singleton")
 */
class TipCupController extends AbstractActionController
{

    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\TeamRepository
     */
    protected $teamRepository;

    /**
     * @var \AchimFritz\ChampionShip\Tip\Domain\Repository\TipCupRepository
     * @Flow\Inject
     */
    protected $tipCupRepository;

    /**
     * @var string
     */
    protected $resourceArgumentName = 'tipCup';

    /**
     * @return void
     */
    public function initializeAction()
    {
        if ($this->request->hasArgument($this->resourceArgumentName) === true) {
            $propertyMappingConfiguration = $this->arguments[$this->resourceArgumentName]->getPropertyMappingConfiguration();
            $propertyMappingConfiguration->setTypeConverterOption('TYPO3\Flow\Property\TypeConverter\PersistentObjectConverter', \TYPO3\Flow\Property\TypeConverter\PersistentObjectConverter::CONFIGURATION_MODIFICATION_ALLOWED, true);
            $propertyMappingConfiguration->allowAllProperties();
            $propertyMappingConfiguration
                ->forProperty('cup.startDate')
                ->setTypeConverterOption(
                    'TYPO3\Flow\Property\TypeConverter\DateTimeConverter',
                    \TYPO3\Flow\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT,
                    'd.m.Y H:i'
                );
        }
        parent::initializeAction();
    }

    /**
     * @param \TYPO3\Flow\Mvc\View\ViewInterface $view
     * @return void
     */
    protected function initializeView(\TYPO3\Flow\Mvc\View\ViewInterface $view)
    {
        parent::initializeView($view);
        $tipCups = $this->tipCupRepository->findAll();
        $cupsWithoutTips = array();
        foreach ($this->cups as $cup) {
            $tipCupExists = false;
            foreach ($tipCups as $tipCup) {
                if ($cup === $tipCup->getCup()) {
                    $tipCupExists = true;
                }
            }
            if ($tipCupExists === false) {
                $cupsWithoutTips[] = $cup;
            }
        }
        $this->view->assign('cups', $cupsWithoutTips);
        $this->view->assign('tipCups', $tipCups);
        $this->view->assign('allTeams', $this->teamRepository->findAll());
    }

    /**
     * @return void
     */
    public function listAction()
    {
    }

    /**
     * @param \AchimFritz\ChampionShip\Tip\Domain\Model\TipCup $tipCup
     * @return void
     */
    public function showAction(TipCup $tipCup)
    {
        $this->view->assign('tipCup', $tipCup);
    }

    /**
     * @param \AchimFritz\ChampionShip\Tip\Domain\Model\TipCup $tipCup
     * @return void
     */
    public function updateAction(TipCup $tipCup)
    {
        $this->tipCupRepository->update($tipCup);
        $this->addOkMessage('tipCup updated');
        $this->redirect('index');
    }

    /**
     * @param \AchimFritz\ChampionShip\Tip\Domain\Model\TipCup $tipCup
     * @return void
     */
    public function createAction(TipCup $tipCup)
    {
        $this->tipCupRepository->add($tipCup);
        $this->addOkMessage('tipCup created');
        $this->redirect('index');
    }

    /**
     * @param \AchimFritz\ChampionShip\Tip\Domain\Model\TipCup $tipCup
     * @return void
     */
    public function deleteAction(TipCup $tipCup)
    {
        $this->tipCupRepository->remove($tipCup);
        $this->addOkMessage('tipCup deleted');
        $this->redirect('index');
    }
}
