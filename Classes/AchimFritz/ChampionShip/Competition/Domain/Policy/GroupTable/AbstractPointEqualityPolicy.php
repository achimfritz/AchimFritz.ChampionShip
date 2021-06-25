<?php
namespace AchimFritz\ChampionShip\Competition\Domain\Policy\GroupTable;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "AchimFritz.ChampionShip".*
 *                                                                        *
 *                                                                        */

use AchimFritz\ChampionShip\Competition\Domain\Model\GroupRound;
use Neos\Flow\Annotations as Flow;
use AchimFritz\ChampionShip\Competition\Domain\Model\GroupTableRow;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * AbstractPointEqualityPolicy
 *
 *	@Flow\Scope("singleton")
 */
abstract class AbstractPointEqualityPolicy
{


    /**
     * @var \AchimFritz\ChampionShip\Competition\Domain\Policy\GroupTable\DefaultPolicy
     * @Flow\Inject
     */
    protected $defaultPolicy;

    /**
     * @Flow\Inject
     * @var \Neos\Flow\Log\SystemLoggerInterface
     */
    protected $systemLogger;

    /**
     * rowsAreEquay
     *
     * @param GroupTableRow $rowOne
     * @param GroupTableRow $rowTwo
     * @return boolean
     */
    abstract protected function rowsAreEqual(GroupTableRow $rowOne, GroupTableRow $rowTwo);

    /**
     * getPolicyName
     *
     * @return string
     */
    abstract protected function getPolicyName();

    /**
     * addMessage
     *
     * @param string $message
     * @return void
     */
    protected function addMessage($message)
    {
        $this->systemLogger->log($this->getPolicyName() . ': ' . $message, LOG_INFO);
    }

    /**
     * getMatchOfTwoRows
     *
     * @param \Doctrine\Common\Collections\Collection $matches
     * @param GroupTableRow $row
     * @param GroupTableRow $next
     * @return void
     */
    protected function getMatchOfTwoRows(\Doctrine\Common\Collections\Collection $matches, GroupTableRow $row, GroupTableRow $next)
    {
        $teamOne = $row->getTeam();
        $teamTwo = $next->getTeam();
        foreach ($matches as $match) {
            if ($match->getTwoTeamsPlayThisMatch($teamOne, $teamTwo)) {
                return $match;
            }
        }
    }

    /**
     * getRelevantMatches
     *
     * @param array<GroupTableRow> $rows
     * @param Collection<GroupMatch> $matches
     * @return ArrayCollection<GroupMatch> $relavant
     */
    protected function getRelevantMatches(array $rows, Collection $matches)
    {
        $relevant = new ArrayCollection();
        if (count($rows) == 2) {
            $match = $this->getMatchOfTwoRows($matches, $rows[0], $rows[1]);
            if ($match->isPlayedAndNotRemis()) {
                $relevant->add($match);
            }
        } elseif (count($rows) === 3) {
            $matchOne = $this->getMatchOfTwoRows($matches, $rows[0], $rows[1]);
            $relevant->add($matchOne);
            $matchTwo = $this->getMatchOfTwoRows($matches, $rows[0], $rows[2]);
            $relevant->add($matchTwo);
            $matchThree = $this->getMatchOfTwoRows($matches, $rows[1], $rows[2]);
            $relevant->add($matchThree);
            if ($matchOne->isPlayedAndNotRemis() === false && $matchTwo->isPlayedAndNotRemis() === false && $matchThree->isPlayedAndNotRemis() === false) {
                $relevant = new ArrayCollection();
            }
        }
        return $relevant;
    }

    /**
     * pointEquality
     *
     * @param array<GroupTableRow> $rows
     * @param Collection<GroupMatch> $matches
     * @return ArrayCollection<GroupMatch> $relavant
     */
    protected function pointEquality(array $rows, Collection $matches)
    {
        $this->addMessage('checking ' . count($rows) . ' teams');

        $first = $rows[0];
        $startRank = $first->getRank() - 1;
        foreach ($rows as $row) {
            $this->addMessage($row->getTeam()->getName() . ' with rank ' . $row->getRank());
        }
        $relevant = $this->getRelevantMatches($rows, $matches);
        if (count($relevant) > 0) {
            $round = new GroupRound();
            $groupTableRows = $round->getGroupTableRowsByResults($relevant);
            $groupTableRows = $this->defaultPolicy->updateTable($groupTableRows);
            $arr = array();
            foreach ($groupTableRows as $groupTableRow) {
                $arr[$groupTableRow->getTeam()->getName()] = $groupTableRow;
            }
            foreach ($rows as $row) {
                $teamName = $row->getTeam()->getName();
                $new = $arr[$teamName];
                $rank = $startRank + $new->getRank();
                $this->addMessage('new rank of ' . $teamName . ' is ' . $rank);
                $row->setRank($rank);
            }
        }
    }

    /**
     * updateTable
     *
     * @param array<\AchimFritz\ChampionShip\Competition\Domain\Model\GroupTableRow>
      * @param \Doctrine\Common\Collections\Collection<\AchimFritz\ChampionShip\Competition\Domain\Model\GroupMatch>
     * @return array<\AchimFritz\ChampionShip\Competition\Domain\Model\GroupTableRow>
     */
    public function updateTable(array $rows, Collection $matches)
    {
        $first = $matches->first();
        $this->addMessage('updateTable ' . $first->getRound()->getName() . ' ' . $first->getCup()->getName() . ' with ' . count($rows) . ' rows');
        $rows = $this->defaultPolicy->updateTable($rows, $matches);
        // numeric array
        $res = [];
        foreach ($rows as $row) {
            $res[] = $row;
        }
        for ($i = 0; $i < count($res) - 1; $i++) {
            $row = $res[$i];
            $next = $res[$i+1];
            if ($this->rowsAreEqual($row, $next)) {
                if ($i + 2 < count($res)) {
                    $overNext = $res[$i+2];
                    if ($this->rowsAreEqual($next, $overNext)) {
                        $this->addMessage('case 1 point equality with 3 teams, i=' . $i);
                        $this->addMessage($row->getTeam()->getName() . ' - ' . $next->getTeam()->getName() . ' - ' . $overNext->getTeam()->getName());
                        $this->pointEquality(array($row, $next, $overNext), $matches);
                        //finish
                        $i++;
                    } else {
                        $this->addMessage('case 2 point equality with 2 teams, i=' . $i);
                        $this->pointEquality(array($row, $next), $matches);
                    }
                } else {
                    $this->addMessage('case 3 point equality with 2 teams, i=' . $i);
                    $this->pointEquality(array($row, $next), $matches);
                }
            }
        }
        // assoc array
        $new = array();
        foreach ($res as $row) {
            $name = $row->getTeam()->getName();
            $new[$name] = $row;
        }
        return $new;
    }
}
