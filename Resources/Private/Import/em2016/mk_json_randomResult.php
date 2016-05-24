<?php

$content = file_get_contents('matches.txt');
$lines = explode("\n", $content);
$cnt = 1;
$t = array(0,0,0,1,1,1,1,2,2,3,3,4,5);
foreach ($lines AS $line) {
	$arr = explode("\t", $line);
	if (count($arr) >= 7) {
		$date = str_replace('. ', '.2016 ', trim($arr[1]));
		$dateObj = new \DateTime($date);
		$r = rand(0, count($t) - 1);
		$g1 = $t[$r];
		$r = rand(0, count($t) - 1);
		$g2 = $t[$r];
		$item = array(
			'match' => array(
				'name' => $cnt,
				'homeTeam' => trim($arr[4]),
				'guestTeam' => trim($arr[6]),
				'groupName' => trim($arr[3]),
				'homeGoals' => $g1,
				'guestGoals' => $g2,
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
