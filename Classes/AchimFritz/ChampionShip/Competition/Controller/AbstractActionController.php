<?php
namespace AchimFritz\ChampionShip\Competition\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */


use Neos\Flow\Annotations as Flow;
use \AchimFritz\ChampionShip\Competition\Domain\Model\Cup;

/**
 * Action controller for the AchimFritz.ChampionShip package
 *
 * @Flow\Scope("singleton")
 */
class AbstractActionController extends \AchimFritz\ChampionShip\Generic\Controller\AbstractActionController
{

    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\CupRepository
     */
    protected $cupRepository;

    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\MatchRepository
     */
    protected $cupMatchRepository;

    /**
     * @var Cup
     */
    protected $cup = null;

    /**
     * @var \Neos\Flow\Persistence\QueryResultInterface
     */
    protected $cups = null;


    /**
     * initializeAction
     *
     * @return void
     */
    protected function initializeAction()
    {
        if ($this->request->hasArgument('cup')) {
            $arg = $this->request->getArgument('cup');
            if (isset($arg['__identity'])) {
                $this->cup = $this->cupRepository->findByIdentifier($arg['__identity']);
            }
        } else {
            $this->cup = $this->cupRepository->findOneRecent();
        }
        $this->cups = $this->cupRepository->findAll();
    }

    
    /**
     * Allow creation of resources in createAction()
     *
     * @return void
     */
    public function initializeCreateAction()
    {
        $propertyMappingConfiguration = $this->arguments[$this->resourceArgumentName]->getPropertyMappingConfiguration();
        $propertyMappingConfiguration->setTypeConverterOption('Neos\Flow\Property\TypeConverter\PersistentObjectConverter', \Neos\Flow\Property\TypeConverter\PersistentObjectConverter::CONFIGURATION_CREATION_ALLOWED, true);
        $propertyMappingConfiguration->allowAllProperties();
        $propertyMappingConfiguration
            ->forProperty('startDate')
            ->setTypeConverterOption(
                    'Neos\Flow\Property\TypeConverter\DateTimeConverter',
                    \Neos\Flow\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT,
                    'd.m.Y H:i'
                    );
    }

    /**
     * Allow modification of resources in updateAction()
     *
     * @return void
     */
    public function initializeUpdateAction()
    {
        $propertyMappingConfiguration = $this->arguments[$this->resourceArgumentName]->getPropertyMappingConfiguration();
        $propertyMappingConfiguration->setTypeConverterOption('Neos\Flow\Property\TypeConverter\PersistentObjectConverter', \Neos\Flow\Property\TypeConverter\PersistentObjectConverter::CONFIGURATION_MODIFICATION_ALLOWED, true);
        $propertyMappingConfiguration->allowAllProperties();
        $propertyMappingConfiguration
            ->forProperty('startDate')
            ->setTypeConverterOption(
                    'Neos\Flow\Property\TypeConverter\DateTimeConverter',
                    \Neos\Flow\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT,
                    'd.m.Y H:i'
                    );
    }

    /**
     * initializeView
     *
     * @return void
     */
    protected function initializeView(\Neos\Flow\Mvc\View\ViewInterface $view)
    {
        $view->assign('controllers', array('Team', 'User', 'Cup', 'Standard'));
        $view->assign('title', $this->request->getControllerName() . '.' . $this->request->getControllerActionName());
        $this->view->assign('cup', $this->cup);
        $this->view->assign('recentCup', $this->cup);
        if ($this->cup instanceof Cup) {
            $nextMatches = $this->cupMatchRepository->findNextByCup($this->cup);
            $this->view->assign('nextMatches', $nextMatches);
            $lastMatches = $this->cupMatchRepository->findLastByCup($this->cup);
            $this->view->assign('lastMatches', $lastMatches);
        }
        $this->view->assign('cups', $this->cups);
    }
}
