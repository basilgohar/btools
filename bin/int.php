#!/usr/bin/php
<?php

$timestart = microtime(true);

if (isset($argv[1])) {
    $iterations = (int) $argv[1];
} else {
    $iterations = 1000000;
}

if (isset($argv[2])) {
    $method = $argv[2];
} else {
    $method = 'default';
}

$count = 0;
$sum = 0;
$increment = 1;

switch ($method) {
    default:
        while ($count < $iterations) {
            ++$count;
            $sum += $increment;
        }
        break;
    case 'bcmath':
        $sumbcmath = (string) $sum;
        $incrementbcmath = (string) $increment;
        while ($count < $iterations) {
            ++$count;
            $sumbcmath = bcadd($sumbcmath, $incrementbcmath);
        }
        $sum = $sumbcmath;
        break;
    case 'gmp':
        $sumgmp = gmp_init($sum);
        $incrementgmp = gmp_init($increment);
        while ($count < $iterations) {
            ++$count;
            $sumgmp = gmp_add($sumgmp, $incrementgmp);
        }
        $sum = gmp_strval($sumgmp);
        break;
}

var_dump($sum);

$timeend = microtime(true);

$timetotal = $timeend - $timestart;
$iterations_per_second = $iterations/$timetotal;

echo "Processed $iterations iterations in $timetotal seconds ($iterations_per_second iterations per second)\n";
