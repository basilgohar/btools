#!/usr/bin/php
<?php

$start_time = microtime(true);

define('REGEX_COMBINEDIOVHOST', '/^([^\s]+) ([0-9.]+) (.*) (.*) \[(.+)\] "(.*)" ([0-9]+) ([0-9-]+) "(.*)" "(.*)" ([0-9-]+) ([0-9-]+)$/');
define('REGEX_COMBINED', '/^([0-9a-z.-]+) - (.+) \[(.+)\] "(.*)" ([0-9]+) ([0-9-]+) "(.*)" "(.*)"$/');
define('REGEX_COMMON', '/^([0-9a-z.-]+) - (.+) \[(.+)\] "(.*)" ([0-9]+) ([0-9-]+)$/');

$REGEX_COMBINEDIOVHOST = REGEX_COMBINEDIOVHOST;

$count = 0;

if (! isset($argv[1])) {
    echo "No input file was specified\n";
    exit;
}

if (! isset($argv[2])) {
    echo "No output file was specified\n";
    exit;
}

if (! file_exists($argv[1])) {
    echo "Specified input file does not exist\n";
    exit;
}

if (! $ifp = fopen($argv[1], 'r')) {
    echo "Input file could not be opened\n";
    exit;
}

if (! $ofp = fopen($argv[2], 'w')) {
    echo "Output file could not be opened\n";
    exit;
}

while (false !== ($line = fgets($ifp))) {
    ++$count;
    $line = trim($line);
    if (! preg_match($REGEX_COMBINEDIOVHOST, $line, $matches)) {
        echo "$line\n";
    } else {
        unset($matches[0]);
        fputcsv($ofp, $matches);
    }
}

fclose($ifp);
fclose($ofp);

$total_time = microtime(true) - $start_time;
$iterations_per_second = $count/$total_time;

echo "Processed $count lines in $total_time seconds ($iterations_per_second lines/second)\n";
