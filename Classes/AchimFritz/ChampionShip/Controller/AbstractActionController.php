<?php
namespace AchimFritz\ChampionShip\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Error\Message;
use TYPO3\Flow\Mvc\Controller\RestController;
use \AchimFritz\ChampionShip\Domain\Model\Cup;
use \AchimFritz\ChampionShip\Domain\Model\User;


/**
 * Action controller for the AchimFritz.ChampionShip package 
 *
 * @Flow\Scope("singleton")
 */
class AbstractActionController extends RestController {

	/**
	 * @var \TYPO3\Flow\I18n\Translator
	 * @Flow\Inject
	 */
	protected $translator;

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
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Domain\Repository\UserRepository
	 */
	protected $userRepository;

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
	protected $cup = NULL;

	/**
	 * @var \TYPO3\FLOW3\Persistence\QueryResultInterface
	 */
	protected $cups = NULL;

	/**
	 * @var User
	 */
	protected $user = NULL;


	/**
	 * initializeAction 
	 * 
	 * @return void
	 */
	protected function initializeAction() {
		if ($this->request->hasArgument('cup')) {
			$arg = $this->request->getArgument('cup');
			if (isset($arg['__identity'])) {
				$this->cup = $this->cupRepository->findByIdentifier($arg['__identity']);
			}
		} else {
			$this->cup = $this->cupRepository->findOneRecent();
		}
		$this->cups = $this->cupRepository->findAll();
		$account = $this->securityContext->getAccount();
		if ($account) {
			$user = $this->userRepository->findOneByAccount($account);
			if ($user instanceof User) {
				$this->user = $user;
			}
		}
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
		$this->view->assign('user', $this->user);
		
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
		// autoset cup argument
		if ($arguments === NULL) {
			$arguments = array('cup' => $this->cup);
		} elseif (!isset($arguments['cup'])) {
			$arguments['cup'] = $this->cup;
		}
		// TODO $format = json...
		$contentType = $this->request->getHttpRequest()->getNegotiatedMediaType($this->supportedMediaTypes);
		$format = $this->request->getFormat();
		if ($contentType === 'application/json' OR $format === 'json') {
			// build uri (see parent)
			if ($packageKey !== NULL && strpos($packageKey, '\\') !== FALSE) {
				list($packageKey, $subpackageKey) = explode('\\', $packageKey, 2);
			} else {
				$subpackageKey = NULL;
			}
			$this->uriBuilder->reset();
			if ($format === NULL) {
				$this->uriBuilder->setFormat($this->request->getFormat());
			} else {
				$this->uriBuilder->setFormat($format);
			}

			$uri = $this->uriBuilder->setCreateAbsoluteUri(TRUE)->uriFor($actionName, $arguments, $controllerName, $packageKey, $subpackageKey);

			// check error messages to proof success
			$errorMessages = $this->flashMessageContainer->getMessages(Message::SEVERITY_ERROR);
			if (count($errorMessages) > 0) {
				$success = FALSE;
			} else {
				$success = TRUE;
			}
	
			// create json messages
			$allMessages = $this->flashMessageContainer->getMessagesAndFlush();
			$messages = array();
			foreach ($allMessages AS $message) {
				$messages[] = array('message' => $message->getMessage(), 'title' => $message->getTitle(), 'severity' => $message->getSeverity());
			}

			// create json response
			$response = array(
				'success' => $success,
				'messages' => $messages,
				'see' => $uri,
			);
			$content = json_encode($response);
			$this->response->setContent($content);
			throw new \TYPO3\Flow\Mvc\Exception\StopActionException();
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
		$this->addFlashMessage($message, '', Message::SEVERITY_ERROR);
	}
	
	/**
	 * addWarningMessage
	 * 
	 * @param string $message
	 * @return void
	 */
	protected function addWarningMessage($message) {
		$this->addFlashMessage($message, '', Message::SEVERITY_WARNING);
	}
	/**
	 * addNoticeMessage
	 * 
	 * @param string $message
	 * @return void
	 */
	protected function addNoticeMessage($message) {
		$this->addFlashMessage($message, '', Message::SEVERITY_NOTICE);
	}
	/**
	 * addOkMessage
	 * 
	 * @param string $message
	 * @return void
	 */
	protected function addOkMessage($message) {
		$this->addFlashMessage($message, '', Message::SEVERITY_OK);
	}
	
	/**
	 * handleException
	 * 
	 * @param \Exception $e
	 * @return void
	 */
	protected function handleException(\Exception $e) {
		$this->addFlashMessage($e->getMessage(), get_class($e), Message::SEVERITY_ERROR, array(), $e->getCode());
	}

	/**
	 * Creates a Message object and adds it to the FlashMessageContainer.
	 *
	 * This method should be used to add FlashMessages rather than interacting with the container directly.
	 *
	 * @param string $messageBody text of the FlashMessage
	 * @param string $messageTitle optional header of the FlashMessage
	 * @param string $severity severity of the FlashMessage (one of the \TYPO3\Flow\Error\Message::SEVERITY_* constants)
	 * @param array $messageArguments arguments to be passed to the FlashMessage
	 * @param integer $messageCode
	 * @return void
	 * @throws \InvalidArgumentException if the message body is no string
	 * @see \TYPO3\Flow\Error\Message
	 */
	public function addFlashMessage($messageBody, $messageTitle = '', $severity = Message::SEVERITY_OK, array $messageArguments = array(), $messageCode = NULL) {
		// try to translate message
		$id = 'flashMessage.' . str_replace(' ', '.',  $messageBody);
		$msg = $this->translator->translateById($id, array(), NULL, NULL, 'Main', 'AchimFritz.ChampionShip');
		if ($msg === $id) {
			return parent::addFlashMessage($messageBody, $messageTitle, $severity, $messageArguments, $messageCode);
		} else {
			return parent::addFlashMessage($msg, $messageTitle, $severity, $messageArguments, $messageCode);
		}
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

	/**
	 * A template method for displaying custom error flash messages, or to
	 * display no flash message at all on errors. Override this to customize
	 * the flash message in your action controller.
	 *
	 * @return \TYPO3\Flow\Error\Message The flash message or FALSE if no flash message should be set
	 * @api
	 */
	protected function getErrorFlashMessage() {
		return FALSE;
	}

}

?>
