#!/usr/bin/php
<?php

echo "Welcome to Seemyourlater!
";

echo "Loading data...";

require_once '/var/www/html/play/village/names_array.php';

echo "loaded
";

echo "Generating people...";

$people = array();

for ($i = 0; $i < 10000; ++$i) {
    0 === mt_rand(0, 1) ? $gender = 'male' : $gender = 'female';
    $name_first = $names[$gender][mt_rand(0, count($names[$gender]) - 1)];
    $name_last = $names['last'][mt_rand(0, count($names['last']) - 1)];
    $people[] = array('name_first' => $name_first, 'name_last' => $name_last, 'gender' => $gender);
}

echo "done
";

echo "Generated " . count($people) . " people
";
$option = 0;

while (fscanf(STDIN, "%d", $option)) {
    switch ($option) {
        default:
            break;
        case 1:
            foreach ($people as $person) {
                echo "{$person['name_first']} {$person['name_last']} ({$person['gender']})\n";
            }
            break;
        case 2:
            break;
        case 3:
            break;
    }
    echo "Options:\n";
    echo "1) List all people\n";
    echo "2) Select a portion of people\n";
    echo "3) Quit\n";
}
