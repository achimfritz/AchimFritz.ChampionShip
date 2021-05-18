<?php
namespace AchimFritz\ChampionShip\Competition\Domain\Repository;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use Neos\Flow\Annotations as Flow;

/**
 * A repository for Teams
 *
 * @Flow\Scope("singleton")
 */
class TeamRepository extends \Neos\Flow\Persistence\Repository
{

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->setDefaultOrderings(array('name' => \Neos\Flow\Persistence\QueryInterface::ORDER_ASCENDING));
    }
}
