<?php

$content = file_get_contents('matches.csv');
$lines = explode("\n", $content);
$cnt = 1;
foreach ($lines AS $line) {
	$arr = explode(';', $line);
	if (count($arr) >= 4) {
		$dateItems = explode(' ', trim($arr[3]));
		$dateObj = new \DateTime($dateItems[1] . '2018 ' . str_replace(',', '', $dateItems[2]));
		$item = array(
			'match' => array(
				'name' => $cnt,
				'homeTeam' => trim($arr[1]),
				'guestTeam' => trim($arr[2]),
				'groupName' => trim($arr[0]),
				'roundType' => 1,
				'cupName' => 'wm 2018',
				'startDate' => $dateObj->format('U')
			)
		);
		var_dump($dateObj);
		die();
		#echo json_encode($item, JSON_UNESCAPED_UNICODE);
		#echo "\n";
		$cnt++;
	}
}
