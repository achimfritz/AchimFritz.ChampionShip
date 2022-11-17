<?php

$content = file_get_contents('matches.csv');
$lines = explode("\n", $content);
$cnt = 1;
$itmes = [];
foreach ($lines as $line) {
    $arr = explode(';', $line);
    if (count($arr) >= 4) {
        $dateObj = new \DateTime($arr[1] . '' . $arr[2]);
        $item = [
            'match' => [
                'name' => $cnt,
                'homeTeam' => trim($arr[3]),
                'guestTeam' => trim($arr[5]),
                'groupName' => trim($arr[0]),
                'roundType' => 1,
                'cupName' => 'wm 2022',
                'startDate' => $dateObj->format('U')
            ]
        ];
        $items[] = $item;
        $sort[] = $dateObj->format('U');
    }
}
array_multisort($sort, $items, SORT_NUMERIC);
foreach ($items as $item) {
    $item['match']['name'] = $cnt;
    $cnt++;
    echo json_encode($item, JSON_UNESCAPED_UNICODE);
    echo "\n";
}
