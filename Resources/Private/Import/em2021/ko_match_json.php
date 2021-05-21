<?php

class MatchJson
{
    public function run()
    {
        $lines = explode("\n", file_get_contents('m3.txt'));
        $nr = 1;
        //11.06 21:00 Uhr, Gruppe A in Rom: Türkei - Italien

        foreach ($lines as $line) {
            if (trim($line) === '') {
                continue;
            }
            $t1 = explode(': ', $line);
            [$home, $guest] = explode('-', $t1[1]);
            [$r, $nr, $rest] = explode('xx', $line);
            $t2 = explode(' Uhr ', $rest);
            #var_dump($t2);
            $date = DateTime::createFromFormat('d.m H:i', $t2[0]);
            $arr = [
                'match' => [
                    'name' => (int)$nr,
                    'homeTeam' => trim($home),
                    'guestTeam' => trim($guest),
                    'roundType' => (int)$r,
                    'cupName' => 'em 2021',
                    'startDate' => $date->format('U')
                ]
            ];
            echo json_encode($arr, JSON_UNESCAPED_UNICODE);
            echo "\n";
        }
    }
}

$matchJson = new MatchJson();
$matchJson->run();
