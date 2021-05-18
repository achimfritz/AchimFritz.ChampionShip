<?php
namespace AchimFritz\ChampionShip\Competition\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use Neos\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Competition\Domain\Model\Cup;

/**
 * Team controller for the AchimFritz.ChampionShip package
 *
 * @Flow\Scope("singleton")
 */
class KoRoundCreatorController extends \AchimFritz\ChampionShip\Generic\Controller\AbstractActionController
{


    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\KoRoundRepository
     */
    protected $koRoundRepository;

    /**
     * @var \AchimFritz\ChampionShip\Competition\Domain\Service\KoRoundService
     * @Flow\Inject
     */
    protected $koRoundService;

    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\GroupRoundRepository
     */
    protected $groupRoundRepository;

    /**
     * @var string
     */
    protected $resourceArgumentName = 'cup';

    /**
     * createAction
     *
     * @param \AchimFritz\ChampionShip\Competition\Domain\Model\Cup $cup
     * @return void
     */
    public function createAction(Cup $cup)
    {
        $koRounds = $this->koRoundRepository->findByCup($cup);
        if (count($koRounds) > 0) {
            $this->addErrorMessage('koRounds already exists');
        } else {
            try {
                $groupRounds = $this->groupRoundRepository->findByCup($cup);
                $koRounds = $this->koRoundService->createKoRounds($groupRounds);
                foreach ($koRounds as $koRound) {
                    $this->koRoundRepository->add($koRound);
                }
                $this->addOkMessage('koRounds created');
            } catch (\Exception $e) {
                $this->addErrorMessage('cannot create koRounds');
                $this->handleException($e);
            }
        }
        $this->redirect('index', 'KoRound', null, array('cup' => $cup));
    }
}
