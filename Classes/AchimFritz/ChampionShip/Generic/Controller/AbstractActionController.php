<?php
namespace AchimFritz\ChampionShip\Generic\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Error\Message;
use TYPO3\Flow\Security\Account;
use TYPO3\Flow\Mvc\Controller\RestController;
use \AchimFritz\ChampionShip\Competition\Domain\Model\Cup;
use \AchimFritz\ChampionShip\User\Domain\Model\User;


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
	 * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\CupRepository
	 */
	protected $cupRepository;

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\MatchRepository
	 */
	protected $cupMatchRepository;

	/**
	 * @Flow\Inject
	 * @var \AchimFritz\ChampionShip\User\Domain\Repository\UserRepository
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
	 * @var \TYPO3\Flow\Persistence\QueryResultInterface
	 */
	protected $cups = NULL;

	/**
	 * @var User
	 */
	protected $user = NULL;

	/**
	 * @var Account
	 */
	protected $account = NULL;


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
		$this->account = $this->securityContext->getAccount();
		if ($this->account) {
			$user = $this->userRepository->findOneByAccount($this->account);
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