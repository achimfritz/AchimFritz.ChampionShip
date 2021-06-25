<?php
namespace AchimFritz\ChampionShip\Competition\Domain\Policy\GroupTable;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use Neos\Flow\Annotations as Flow;

/**
 * DefaultPolicy
 */
class DefaultPolicy
{
    /**
     * @Flow\Inject
     * @var \Neos\Flow\Log\SystemLoggerInterface
     */
    protected $systemLogger;

    /**
     * addMessage
     *
     * @param string $message
     * @return void
     */
    protected function addMessage($message)
    {
        $this->systemLogger->log('default policy' . ': ' . $message, LOG_INFO);
    }

   /**
    * @param array <\AchimFritz\ChampionShip\Competition\Domain\Model\GroupTableRow>
    * @return array<\AchimFritz\ChampionShip\Competition\Domain\Model\GroupTableRow>
    */
    public function updateTable(array $rows)
    {
        $this->addMessage('updateTable with ' . count($rows) . ' teams');
        $points = array();
        $goalsDiff = array();
        $goalsPlus = array();
        $names = array();
        foreach ($rows as $name => $row) {
            $points[] = $row->getPoints();
            $goalsDiff[] = $row->getGoalsDiff();
            $goalsPlus[] = $row->getGoalsPlus();
            $names[] = $name;
        }
        array_multisort($points, SORT_DESC, $goalsDiff, SORT_DESC, $goalsPlus, SORT_DESC, SORT_NUMERIC, $names, SORT_ASC, $rows);
        $rank = 1;
        foreach ($rows as $row) {
            $row->setRank($rank);
            $rank++;
        }
        return $rows;
    }
}
