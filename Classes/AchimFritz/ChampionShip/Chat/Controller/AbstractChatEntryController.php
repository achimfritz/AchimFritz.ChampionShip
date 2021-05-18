<?php
namespace AchimFritz\ChampionShip\Chat\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use Neos\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Chat\Domain\Model\ChatEntry;
use AchimFritz\ChampionShip\Tip\Controller\AbstractTipGroupController;

class AbstractChatEntryController extends AbstractTipGroupController
{

    /**
     * @var string
     */
    protected $resourceArgumentName = 'chatEntry';

    /**
     * initializeView
     *
     * @return void
     */
    protected function initializeView(\Neos\Flow\Mvc\View\ViewInterface $view)
    {
        parent::initializeView($view);
        if ($this->user instanceof User) {
            $this->view->assign('user', $this->user);
        } else {
            // admin only
            $this->view->assign('users', $this->userRepository->findAll());
        }
    }

    /**
     * @param \AchimFritz\ChampionShip\Chat\Domain\Model\ChatEntry $chatEntry
     * @return void
     */
    protected function createChatEntry(ChatEntry $chatEntry)
    {
        try {
            $this->chatEntryRepository->add($chatEntry);
            $this->persistenceManager->persistAll();
            $this->addOkMessage('chatEntry created');
        } catch (\Exception $e) {
            $this->addErrorMessage('cannot create chatEntry');
            $this->handleException($e);
        }
    }

    /**
     * @param \AchimFritz\ChampionShip\Chat\Domain\Model\ChatEntry $chatEntry
     * @return void
     */
    protected function updateChatEntry(ChatEntry $chatEntry)
    {
        try {
            $this->chatEntryRepository->update($chatEntry);
            $this->persistenceManager->persistAll();
            $this->addOkMessage('chatEntry updated');
        } catch (\Exception $e) {
            $this->addErrorMessage('cannot update chatEntry');
            $this->handleException($e);
        }
    }

    /**
     * @param \AchimFritz\ChampionShip\Chat\Domain\Model\ChatEntry $chatEntry
     * @return void
     */
    protected function deleteChatEntry(ChatEntry $chatEntry)
    {
        try {
            $this->chatEntryRepository->remove($chatEntry);
            $this->persistenceManager->persistAll();
            $this->addOkMessage('chatEntry deleted');
        } catch (\Exception $e) {
            $this->addErrorMessage('cannot delete chatEntry');
            $this->handleException($e);
        }
    }
}
