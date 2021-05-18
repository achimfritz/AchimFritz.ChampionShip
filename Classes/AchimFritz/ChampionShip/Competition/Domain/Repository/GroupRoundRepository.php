<?php
namespace AchimFritz\ChampionShip\Competition\Domain\Repository;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use Neos\Flow\Annotations as Flow;
use \Neos\Flow\Persistence\QueryInterface;

/**
 * A repository for GroupRounds
 *
 * @Flow\Scope("singleton")
 */
class GroupRoundRepository extends RoundRepository
{
    
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->setDefaultOrderings(array('name' => QueryInterface::ORDER_ASCENDING));
    }
}
