#!/usr/bin/php
<?php

$count = 10000;
$indextype = 'integer';

if (isset($argv[1])) {
    if (! is_numeric($argv[1])) {
        echo "Invalid value for count specified, defaulting to $count\n";
    } else {
        $count = (int) $argv[1];
    }
}

if (isset($argv[2])) {
    $indextype = $argv[2];
}

$increment = 0;
$array = array();

switch ($indextype) {
    default:
        exit("Invalid indextype specified: $indextype\n");
    case 'integer':
        $index = 0;
        break;
    case 'string':
        $index = 'a';
        break;
}

while ($increment < $count) {
    ++$increment;
    $array[$index++] = null;
}

echo memory_get_peak_usage();
