<?php

$content = file_get_contents('koMatches.txt');
$lines = explode("\n", $content);
$first = 37;
$cnt = 37;
foreach ($lines AS $line) {
	$arr = explode("\t", $line);
#var_dump(count($arr));
	if (count($arr) >= 3) {
		$date = trim(preg_replace('/Uhr.*/', ' ', trim($arr[0])));
		$dateObj = new \DateTime($date);
		if ($cnt === 51) {
			$groupName = 'Finale';
			$homeTeam = 'W49';
			$guestTeam = 'W50';
			$roundType = 5;
		} elseif ($cnt > 48) {
			$groupName =  'Halb Finale';
			$homeTeam = 'W' . (string)($first + (int)trim($arr[1]) + 7);
			$guestTeam = 'W' . (string)($first + (int)trim($arr[3]) + 7);
			$roundType = 4;
		} elseif ($cnt > 44) {
			$groupName = 'Viertel Finale';
			$homeTeam = 'W' . (string)($first + (int)trim($arr[1]) - 1);
			$guestTeam = 'W' . (string)($first + (int)trim($arr[3]) - 1);
			$roundType = 3;
		} else {
			$groupName = 'Achtel Finale';
			$roundType = 7;
			$homeTeam = trim($arr[1]);
			$guestTeam = trim(str_replace('/', '', trim($arr[3])));
		}
		$item = array(
			'match' => array(
				'name' => $cnt,
				'homeTeam' => $homeTeam,
				'guestTeam' => $guestTeam,
				'roundType' => $roundType,
				'cupName' => 'em 2016',
				'startDate' => $dateObj->format('U')
			)
		);
		echo json_encode($item, JSON_UNESCAPED_UNICODE);
		echo "\n";
		$cnt++;
		// 
	}
}
