<?php

class MatchJson
{
    public function run()
    {
        $lines = explode("\n", file_get_contents('m2.txt'));
        $nr = 1;
        //11.06 21:00 Uhr, Gruppe A in Rom: Türkei - Italien

        foreach ($lines as $line) {
            if (trim($line) === '') {
                continue;
            }
            $t1 = explode(': ', $line);
            [$home, $guest] = explode('-', $t1[1]);
            $group = preg_replace('/.*, Gruppe (.*) in .*/', '$1', $line);
            $t2 = explode(' Uhr, ', $line);
            #var_dump($t2);
            $date = DateTime::createFromFormat('d.m H:i', $t2[0]);
            $arr = [
                'match' => [
                    'name' => $nr,
                    'homeTeam' => trim($home),
                    'guestTeam' => trim($guest),
                    'groupName' => $group,
                    'roundType' => 1,
                    'cupName' => 'em 2021',
                    'startDate' => $date->format('U')
                ]
            ];
            echo json_encode($arr, JSON_UNESCAPED_UNICODE);
            echo "\n";
            $nr++;
            //{"match":{"name":"1","homeTeam":"Brasilien","guestTeam":"Kroatien","groupName":"A","roundType":1,"cupName":"wm 2014","startDate":"1402603200"}}
        }
    }
}

$matchJson = new MatchJson();
$matchJson->run();
