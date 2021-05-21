<?php
namespace AchimFritz\ChampionShip\Competition\Domain\Policy\GroupTable;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use AchimFritz\ChampionShip\Competition\Domain\Model\Cup;
use AchimFritz\ChampionShip\Competition\Domain\Model\ExtraPoint;
use Neos\Flow\Annotations as Flow;

/**
 * BestThirdsPolicy
 */
class BestThirdsPolicy
{

    /**
     * @Flow\Inject
     * @var \AchimFritz\ChampionShip\Competition\Domain\Repository\ExtraPointRepository
     */
    protected $extraPointRepository;

    /**
     * @param array <\AchimFritz\ChampionShip\Competition\Domain\Model\GroupTableRow>
     * @return array<\AchimFritz\ChampionShip\Competition\Domain\Model\GroupTableRow>
     */
    public function updateTable(array $rows)
    {
        $points = array();
        $goalsDiff = array();
        $goalsPlus = array();
        $names = array();
        $extraPoints = array();
        foreach ($rows as $name => $row) {
            $points[] = $row->getPoints();
            $goalsDiff[] = $row->getGoalsDiff();
            $goalsPlus[] = $row->getGoalsPlus();
            $names[] = $name;
            $extraPoint = $this->extraPointRepository->findOneByCupAndTeam($row->getGroupRound()->getCup(), $row->getTeam());
            if ($extraPoint instanceof ExtraPoint === true) {
                $extraPoints[] = $extraPoint->getPoints();
            } else {
                $extraPoints[] = 0;
            }
        }
        array_multisort($points, SORT_DESC, $goalsDiff, SORT_DESC, $goalsPlus, SORT_DESC, SORT_NUMERIC, $extraPoints, SORT_DESC, $names, SORT_ASC, $rows);
        $rank = 1;
        foreach ($rows as $row) {
            $row->setRank($rank);
            $rank++;
        }
        return $rows;
    }

    /**
     * @return array
     */
    public function getRoundMatrix(Cup $cup): array
    {
        // https://de.wikipedia.org/wiki/Fu%C3%9Fball-Europameisterschaft_2016#Einordnung_der_qualifizierten_Gruppendritten_in_das_Achtelfinale
        // https://de.wikipedia.org/wiki/Fu%C3%9Fball-Europameisterschaft_2021#Einordnung_der_qualifizierten_Gruppendritten_in_das_Achtelfinale
        if ($cup->getName() === 'em 2016') {
            return [
                'ABCD' => ['C', 'D', 'A', 'B'],
                'ABCE' => ['C', 'A', 'B', 'E'],
                'ABCF' => ['C', 'A', 'B', 'F'],
                'ABDE' => ['D', 'A', 'B', 'E'],
                'ABDF' => ['D', 'A', 'B', 'F'],
                'ABEF' => ['E', 'A', 'B', 'F'],
                'ACDE' => ['C', 'D', 'A', 'E'],
                'ACDF' => ['C', 'D', 'A', 'F'],
                'ACEF' => ['C', 'A', 'F', 'E'],
                'ADEF' => ['D', 'A', 'F', 'E'],
                'BCDE' => ['C', 'D', 'B', 'E'],
                'BCDF' => ['C', 'D', 'B', 'F'],
                'BCEF' => ['E', 'C', 'B', 'F'],
                'BDEF' => ['E', 'D', 'B', 'F'],
                'CDEF' => ['C', 'D', 'F', 'E']
            ];
        } elseif ($cup->getName() === 'em 2021') {
            return [
                'ABCD' => ['A', 'D', 'B', 'C'],
                'ABCE' => ['A', 'E', 'B', 'C'],
                'ABCF' => ['A', 'F', 'B', 'C'],
                'ABDE' => ['D', 'E', 'A', 'B'],
                'ABDF' => ['D', 'F', 'A', 'B'],
                'ABEF' => ['E', 'F', 'B', 'A'],
                'ACDE' => ['E', 'D', 'C', 'A'],
                'ACDF' => ['F', 'D', 'C', 'A'],
                'ACEF' => ['E', 'F', 'E', 'A'],
                'ADEF' => ['E', 'F', 'D', 'A'],
                'BCDE' => ['E', 'D', 'B', 'C'],
                'BCDF' => ['F', 'D', 'C', 'B'],
                'BCEF' => ['F', 'E', 'C', 'B'],
                'BDEF' => ['F', 'E', 'D', 'B'],
                'CDEF' => ['F', 'E', 'D', 'C']
            ];
        } else {
            return [];
        }
    }

    /**
     * @return array
     */
    public function getOrderRoundsForMatches(Cup $cup)
    {
        if ($cup->getName() === 'em 2016') {
            return ['A', 'B', 'C', 'D'];
        } elseif ($cup->getName() === 'em 2021') {
            return ['B', 'C', 'E', 'F'];
        } else {
            return [];
        }
    }
}
