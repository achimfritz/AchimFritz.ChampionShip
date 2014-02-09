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
	 * initializeAction 
	 * 
	 * @return void
	 */
	protected function initializeAction() {
		$this->cup = NULL;
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
		$this->view->assign('cup', $this->cup);
		$this->view->assign('recentCup', $this->cup);
		if ($this->cup instanceof Cup) {
			$nextMatches = $this->matchRepository->findNextByCup($this->cup);
			$this->view->assign('nextMatches', $nextMatches);
			$lastMatches = $this->matchRepository->findLastByCup($this->cup);
			$this->view->assign('lastMatches', $lastMatches);
		}
		$this->view->assign('cups', $this->cups);
		
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
	 * Redirects the request to another action and / or controller.
	 *
	 * @param string $actionName Name of the action to forward to
	 * @param string $controllerName Unqualified object name of the controller to forward to. If not specified, the current controller is used.
	 * @param string $packageKey Key of the package containing the controller to forward to. If not specified, the current package is assumed.
	 * @param array $arguments Array of arguments for the target action
	 * @param integer $delay (optional) The delay in seconds. Default is no delay.
	 * @param integer $statusCode (optional) The HTTP status code for the redirect. Default is "303 See Other"
	 * @param string $format The format to use for the redirect URI
	 * @return void
	 * @throws \TYPO3\Flow\Mvc\Exception\StopActionException
	 * @see forward()
	 * @api
	 */
	protected function redirect($actionName, $controllerName = NULL, $packageKey = NULL, array $arguments = NULL, $delay = 0, $statusCode = 303, $format = NULL) {
		// TODO $format = json...
		if ($arguments === NULL) {
			$arguments = array('cup' => $this->cup);
		} elseif (!isset($arguments['cup'])) {
			$arguments['cup'] = $this->cup;
		}
		return parent::redirect($actionName, $controllerName, $packageKey, $arguments, $delay, $statusCode, $format);
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
