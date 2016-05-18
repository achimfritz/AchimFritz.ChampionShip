<?php
namespace AchimFritz\ChampionShip\Mvc\View;

class JsonView extends \AchimFritz\Rest\Mvc\View\JsonView {

	/**
	 * @var array
	 */
	protected $configuration = array(
		'cup' => array(
			'_exclude' => array('team')
		),
		'recentCup' => array(
			'_exclude' => array('team')
		),
		'match' => array(
			'_exclude' => array('teamHasWonThisMatch', 'twoTeamsPlayThisMatch')
		),
		'cups' => array(
			'_descendAll' => array(
				'_exclude' => array('team'),
			)
		),
		'nextMatches' => array(
			'_descendAll' => array(
				'_exclude' => array('teamHasWonThisMatch', 'twoTeamsPlayThisMatch'),
			)
		),
		'lastMatches' => array(
			'_descendAll' => array(
				'_exclude' => array('teamHasWonThisMatch', 'twoTeamsPlayThisMatch'),
			)
		)
	);
}
