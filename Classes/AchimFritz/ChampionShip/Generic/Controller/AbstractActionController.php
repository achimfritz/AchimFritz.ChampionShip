<?php
namespace AchimFritz\ChampionShip\Generic\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Error\Message;
use AchimFritz\Rest\Controller\RestController;

/**
 * Action controller for the AchimFritz.ChampionShip package
 *
 * @Flow\Scope("singleton")
 */
class AbstractActionController extends RestController
{

    /**
     * @var \TYPO3\Flow\I18n\Translator
     * @Flow\Inject
     */
    protected $translator;

    /**
     * @var array
     */
    protected $viewFormatToObjectNameMap = array('json' => 'AchimFritz\\ChampionShip\\Mvc\\View\\JsonView');

    /**
     * @return void
     */
    protected function redirectHome()
    {
        $this->redirect('list', 'Standard', 'AchimFritz.ChampionShip\\Generic');
    }

    /**
     * @return void
     */
    protected function forwardHome()
    {
        $this->forward('list', 'Standard', 'AchimFritz.ChampionShip\\Generic');
    }


    /**
     * initializeView
     *
     * @return void
     */
    protected function initializeView(\TYPO3\Flow\Mvc\View\ViewInterface $view)
    {
        $view->assign('controllers', array('Team', 'User', 'Cup', 'Standard'));
        $view->assign('title', $this->request->getControllerName() . '.' . $this->request->getControllerActionName());
    }

    /**
     * addErrorMessage
     *
     * @param string $message
     * @return void
     */
    protected function addErrorMessage($message)
    {
        $this->addFlashMessage($message, '', Message::SEVERITY_ERROR);
    }
    
    /**
     * addWarningMessage
     *
     * @param string $message
     * @return void
     */
    protected function addWarningMessage($message)
    {
        $this->addFlashMessage($message, '', Message::SEVERITY_WARNING);
    }
    /**
     * addNoticeMessage
     *
     * @param string $message
     * @return void
     */
    protected function addNoticeMessage($message)
    {
        $this->addFlashMessage($message, '', Message::SEVERITY_NOTICE);
    }
    /**
     * addOkMessage
     *
     * @param string $message
     * @return void
     */
    protected function addOkMessage($message)
    {
        $this->addFlashMessage($message, '', Message::SEVERITY_OK);
    }
    
    /**
     * handleException
     *
     * @param \Exception $e
     * @return void
     */
    protected function handleException(\Exception $e)
    {
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
    public function addFlashMessage($messageBody, $messageTitle = '', $severity = Message::SEVERITY_OK, array $messageArguments = array(), $messageCode = null)
    {
        // try to translate message
        $id = 'flashMessage.' . str_replace(' ', '.', $messageBody);
        $msg = $this->translator->translateById($id, array(), null, null, 'Main', 'AchimFritz.ChampionShip');
        if ($msg === $id) {
            return parent::addFlashMessage($messageBody, $messageTitle, $severity, $messageArguments, $messageCode);
        } else {
            return parent::addFlashMessage($msg, $messageTitle, $severity, $messageArguments, $messageCode);
        }
    }

    /**
     * A template method for displaying custom error flash messages, or to
     * display no flash message at all on errors. Override this to customize
     * the flash message in your action controller.
     *
     * @return \TYPO3\Flow\Error\Message The flash message or FALSE if no flash message should be set
     * @api
     */
    protected function getErrorFlashMessage()
    {
        return false;
    }
}
