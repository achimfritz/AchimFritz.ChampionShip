<?php

$content = file_get_contents('matches.txt');
$lines = explode("\n", $content);
$cnt = 1;
foreach ($lines AS $line) {
	$arr = explode("\t", $line);
	if (count($arr) >= 7) {
		$date = str_replace('. ', '.2016 ', trim($arr[1]));
		$dateObj = new \DateTime($date);
		$item = array(
			'match' => array(
				'name' => $cnt,
				'homeTeam' => trim($arr[4]),
				'guestTeam' => trim($arr[6]),
				'groupName' => trim($arr[3]),
				'roundType' => 1,
				'cupName' => 'em 2016',
				'startDate' => $dateObj->format('U')
			)
		);
		echo json_encode($item, JSON_UNESCAPED_UNICODE);
		echo "\n";
		$cnt++;
		// {"match":{"name":"1","homeTeam":"Brasilien",
		//"guestTeam":"Kroatien","groupName":"A","roundType":1,"cupName":"testfoo","startDate":"1402603200"}}
	}
}
