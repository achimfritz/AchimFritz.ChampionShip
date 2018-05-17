<?php
namespace AchimFritz\ChampionShip\Mvc\View;

use AchimFritz\ChampionShip\Competition\Domain\Model\CrossGroupMatch;
use AchimFritz\ChampionShip\Competition\Domain\Model\CrossGroupWithThirdsMatch;
use AchimFritz\ChampionShip\Competition\Domain\Model\GroupMatch;
use AchimFritz\ChampionShip\Competition\Domain\Model\Team;
use AchimFritz\ChampionShip\Competition\Domain\Model\TeamsOfTwoMatchesMatch;

class MatchesJsonView extends JsonView
{



    /**
     * Transforms the value view variable to a serializable
     * array represantion using a YAML view configuration and JSON encodes
     * the result.
     *
     * @return string The JSON encoded variables
     * @api
     */
    public function render()
    {
        $matches = $this->variables['matches'];
        $res = array();
        foreach ($matches as $match) {
            $json = array(
                'startDate' => $match->getStartDate()->format('d.m.Y H:i'),
                'startDateXs' => $match->getStartDate()->format('d.m H:i'),
                'name' => $match->getName()
            );
            if ($match->getResult() !== null) {
                $json['result'] = array(
                    'hostTeamGoals' => $match->getResult()->getHostTeamGoals(),
                    'guestTeamGoals' => $match->getResult()->getGuestTeamGoals(),
                );
            }
            $team = $match->getHostTeam();
            if ($team instanceof Team) {
                $team = $match->getHostTeam();
                $json['hostTeam'] = array(
                    'name' => $team->getName(),
                    'iso2' => $team->getIso2(),
                    'iso3' => $team->getIso3Upper()
                );
            } else {
                if ($match instanceof CrossGroupMatch) {
                    if ($match instanceof CrossGroupWithThirdsMatch) {
                        $res['hostTeamName'] = $match->getHostGroupRank() . ' ' . $match->getHostGroupRound();
                    } else {
                        if ($match instanceof TeamsOfTwoMatchesMatch) {
                            if ($match->getHostMatchIsWinner() === true) {
                                $res['hostTeamName'] = '1.' . $match->getHostMatch()->getName();
                            } else {
                                $res['hostTeamName'] = '2. ' . $match->getHostMatch()->getName();
                            }
                        }
                    }
                }
            }
            $team = $match->getGuestTeam();
            if ($team instanceof Team) {
                $json['guestTeam'] = array(
                    'name' => $team->getName(),
                    'iso2' => $team->getIso2(),
                    'iso3' => $team->getIso3Upper()
                );
            } else {
                if ($match instanceof CrossGroupMatch) {
                    if ($match instanceof CrossGroupWithThirdsMatch) {
                        $rounds = $match->getGuestGroupRounds();
                        $roundName = array();
                        foreach ($rounds as $round) {
                            $roundName[] = $round->getName();
                        }
                        $res['guestTeamName'] = $match->getGuestGroupRank() . ' ' . implode(',', $roundName);
                    } else {
                        $res['guestTeamName'] = $match->getGuestGroupRank() . ' ' . $match->getGuestGroupRound();
                    }
                } else {
                    if ($match instanceof TeamsOfTwoMatchesMatch) {
                        if ($match->getHostMatchIsWinner() === true) {
                            $res['guestTeamName'] = '2.' . $match->getGuestMatch()->getName();
                        } else {
                            $res['guestTeamName'] = '1. ' . $match->getGuestMatch()->getName();
                        }
                    }
                }
            }
            $res[] = $json;
        }
        return json_encode(array('matches' => $res));
    }
}
