<?php
namespace AchimFritz\ChampionShip\Chat\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Chat\Domain\Model\OpenChatEntry;

class OpenChatEntryController extends AbstractChatEntryController
{

    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\Chat\Domain\Repository\OpenChatEntryRepository
     */
    protected $chatEntryRepository;

    /**
     * @return void
     */
    public function listAction()
    {
        $this->view->assign('chatEntries', $this->chatEntryRepository->findAll());
    }

    /**
     * @param \AchimFritz\ChampionShip\Chat\Domain\Model\OpenChatEntry $chatEntry
     * @return void
     */
    public function showAction(OpenChatEntry $chatEntry)
    {
        $this->view->assign('chatEntry', $chatEntry);
    }

    /**
     * @param \AchimFritz\ChampionShip\Chat\Domain\Model\OpenChatEntry $chatEntry
     * @return void
     */
    public function createAction(OpenChatEntry $chatEntry)
    {
        $this->createChatEntry($chatEntry);
        $this->redirect('index');
    }

    /**
     * @param \AchimFritz\ChampionShip\Chat\Domain\Model\OpenChatEntry $chatEntry
     * @return void
     */
    public function updateAction(OpenChatEntry $chatEntry)
    {
        $this->updateChatEntry($chatEntry);
        $this->redirect('index');
    }

    /**
     * @param \AchimFritz\ChampionShip\Chat\Domain\Model\OpenChatEntry $chatEntry
     * @return void
     */
    public function deleteAction(OpenChatEntry $chatEntry)
    {
        $this->deleteChatEntry($chatEntry);
        $this->redirect('index');
    }
}
