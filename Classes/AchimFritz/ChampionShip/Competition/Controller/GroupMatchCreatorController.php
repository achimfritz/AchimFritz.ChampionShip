<?php
namespace AchimFritz\ChampionShip\Competition\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use Neos\Flow\Annotations as Flow;

use AchimFritz\ChampionShip\Competition\Domain\Model\GroupRound;

/**
 * Team controller for the AchimFritz.ChampionShip package
 *
 * @Flow\Scope("singleton")
 */
class GroupMatchCreatorController extends \AchimFritz\ChampionShip\Generic\Controller\AbstractActionController
{

    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\GroupRoundRepository
     */
    protected $roundRepository;

    /**
     * @var string
     */
    protected $resourceArgumentName = 'groupRound';

    /**
     * Updates the given team object
     *
     * @param \AchimFritz\ChampionShip\Competition\Domain\Model\GroupRound $groupRound
     * @return void
     */
    public function updateAction(GroupRound $groupRound)
    {
        try {
            $groupRound->createMatches();
            $this->roundRepository->update($groupRound);
            $this->persistenceManager->persistAll();
            $this->addOkMessage('matches updated');
        } catch (\Exception $e) {
            $this->addErrorMessage('cannot update matches');
            $this->handleException($e);
        }
        $this->redirect('index', 'GroupRound', null, array('round' => $groupRound));
    }
}
