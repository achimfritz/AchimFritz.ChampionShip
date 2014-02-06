<?php
namespace AchimFritz\ChampionShip\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Mvc\Controller\RestController;
use \AchimFritz\ChampionShip\Domain\Model\Cup;


/**
 * Action controller for the AchimFritz.ChampionShip package 
 *
 * @Flow\Scope("singleton")
 */
#class ActionController extends \TYPO3\Flow\Mvc\Controller\ActionController {
class ActionController extends RestController {

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\CupRepository
	 */
	protected $cupRepository;

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\MatchRepository
	 */
	protected $matchRepository;
	
	/**
	 * @var \TYPO3\Flow\Security\Context
	 * @Flow\Inject
	 */
	protected $securityContext;
	
	/**
    * Supported content types. Needed for HTTP content negotiation.
    * @var array
    */
   protected $supportedMediaTypes = array('text/html', 'application/json', 'application/xml');

	/**
	 * @var Cup
	 */
	protected $cup;

	/**
	 * @var \TYPO3\FLOW3\Persistence\QueryResultInterface
	 */
	protected $cups;

	
	/**
	 * Allow creation of resources in createAction()
	 *
	 * @return void
	 */
	public function initializeCreateAction() {
		$propertyMappingConfiguration = $this->arguments[$this->resourceArgumentName]->getPropertyMappingConfiguration();
		$propertyMappingConfiguration->setTypeConverterOption('TYPO3\Flow\Property\TypeConverter\PersistentObjectConverter', \TYPO3\Flow\Property\TypeConverter\PersistentObjectConverter::CONFIGURATION_CREATION_ALLOWED, TRUE);
		$propertyMappingConfiguration->allowAllProperties();
		$propertyMappingConfiguration
			->forProperty('startDate')
			->setTypeConverterOption(
					'TYPO3\Flow\Property\TypeConverter\DateTimeConverter',
					\TYPO3\Flow\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT,
					'd.m.Y H:i'
					);
	}

	/**
	 * Allow modification of resources in updateAction()
	 *
	 * @return void
	 */
	public function initializeUpdateAction() {
		$propertyMappingConfiguration = $this->arguments[$this->resourceArgumentName]->getPropertyMappingConfiguration();
		$propertyMappingConfiguration->setTypeConverterOption('TYPO3\Flow\Property\TypeConverter\PersistentObjectConverter', \TYPO3\Flow\Property\TypeConverter\PersistentObjectConverter::CONFIGURATION_MODIFICATION_ALLOWED, TRUE);
		$propertyMappingConfiguration->allowAllProperties();
		$propertyMappingConfiguration
			->forProperty('startDate')
			->setTypeConverterOption(
					'TYPO3\Flow\Property\TypeConverter\DateTimeConverter',
					\TYPO3\Flow\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT,
					'd.m.Y H:i'
					);
	}


	/**
	 * initializeView
	 * 
	 * @return void
	 */
	protected function initializeView(\TYPO3\Flow\Mvc\View\ViewInterface $view) {
		$view->assign('controllers', array('Team', 'User', 'Cup', 'Standard'));
		$view->assign('title', $this->request->getControllerName() . '.' . $this->request->getControllerActionName());
		
		$cup = NULL;	
		if ($this->request->hasArgument('cup')) {
			$arg = $this->request->getArgument('cup');
			if (isset($arg['__identity'])) {
				$cup = $this->cupRepository->findByIdentifier($arg['__identity']);
				$this->view->assign('recentCup', $cup);
			}
		} else {
			$cup = $this->cupRepository->findOneRecent();
			$this->view->assign('recentCup', $cup);
		}
		if ($cup instanceof Cup) {
			$nextMatches = $this->matchRepository->findNextByCup($cup);
			$this->view->assign('nextMatches', $nextMatches);
			$lastMatches = $this->matchRepository->findLastByCup($cup);
			$this->view->assign('lastMatches', $lastMatches);
			$this->cup = $cup;
		}
		$cups = $this->cupRepository->findAll();
		$this->cups = $cups;
		$this->view->assign('cups', $cups);
		
	}
	
	/**
	 * resolveViewObjectName
	 * 
	 * @return void
	 */
	protected function resolveViewObjectName() {
/* TODO
goes to
Accept:application/json
not
curl -X GET  -H "Content-Type:application/json" http://cs2/achimfritz.championship.import/wmTwoSix/index
*/
		$contentType = $this->request->getHttpRequest()->getNegotiatedMediaType($this->supportedMediaTypes);
		$format = $this->request->getFormat();
		if ($contentType === 'application/xml' OR $format === 'xml') {
			$this->request->setFormat('xml');
			$this->response->setHeader('Content-Type', 'application/xml');
			return parent::resolveViewObjectName();
		} elseif ($contentType === 'application/json' OR $format === 'json') {
			$this->request->setFormat('json');
			$this->response->setHeader('Content-Type', 'application/json');
			return parent::resolveViewObjectName();
			#return 'TYPO3\\Flow\\Mvc\\View\\JsonView';
		} else {
			return parent::resolveViewObjectName();
		}
	}

	/**
	 * addErrorMessage
	 * 
	 * @param string $message
	 * @return void
	 */
	protected function addErrorMessage($message) {
		$this->addFlashMessage($message, '', \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
	}
	
	/**
	 * addWarningMessage
	 * 
	 * @param string $message
	 * @return void
	 */
	protected function addWarningMessage($message) {
		$this->addFlashMessage($message, '', \TYPO3\Flow\Error\Message::SEVERITY_WARNING);
	}
	/**
	 * addNoticeMessage
	 * 
	 * @param string $message
	 * @return void
	 */
	protected function addNoticeMessage($message) {
		$this->addFlashMessage($message, '', \TYPO3\Flow\Error\Message::SEVERITY_NOTICE);
	}
	/**
	 * addOkMessage
	 * 
	 * @param string $message
	 * @return void
	 */
	protected function addOkMessage($message) {
		$this->addFlashMessage($message, '', \TYPO3\Flow\Error\Message::SEVERITY_OK);
	}
	
	/**
	 * handleException
	 * 
	 * @param \Exception $e
	 * @return void
	 */
	protected function handleException(\Exception $e) {
		$this->addFlashMessage($e->getMessage(), get_class($e), \TYPO3\Flow\Error\Message::SEVERITY_ERROR, array(), $e->getCode());
	}

	/**
	 * errorAction 
	 * 
	 * @return void
	 */
	protected function errorAction() {
		$this->response->setStatus(400);
		return parent::errorAction();
	}

}

?>
