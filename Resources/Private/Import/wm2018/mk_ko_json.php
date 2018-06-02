<?php

$content = file_get_contents('ko_match.txt');
$lines = explode("\n", $content);
foreach ($lines AS $line) {
	$arr = explode(':', $line);
	if (count($arr) >= 7) {
		$dateItems = explode(' ', trim($arr[1]));
		$dateObj = new \DateTime($dateItems[0] . ' ' . $dateItems[1] . ':00');
		$item = array(
			'match' => array(
				'name' => trim($arr[6]),
				'homeTeam' => trim($arr[4]),
				'guestTeam' => trim($arr[5]),
				'roundType' => trim($arr[7]),
				'cupName' => 'wm 2018',
				'startDate' => $dateObj->format('U')
			)
		);
		echo json_encode($item, JSON_UNESCAPED_UNICODE);
		echo "\n";
	}
}
