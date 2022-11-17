<?php

$content = file_get_contents('ko_matches.csv');
$lines = explode("\n", $content);
foreach ($lines as $line) {
    $arr = explode(';', $line);
    if (count($arr) >= 4) {
        $dateObj = new \DateTime($arr[1] . '' . $arr[2]);
        $item = [
            'match' => [
                'name' => $arr[9],
                'homeTeam' => trim($arr[7]),
                'guestTeam' => trim($arr[8]),
                'roundType' => trim($arr[10]),
                'cupName' => 'wm 2022',
                'startDate' => $dateObj->format('U')
            ]
        ];
        echo json_encode($item, JSON_UNESCAPED_UNICODE);
        echo "\n";
    }
}
