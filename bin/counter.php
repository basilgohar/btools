#!/usr/bin/php
<?php

$start = microtime(true);

$i = 0;

$PHP_INT_MAX = PHP_INT_MAX;

while ($i < $PHP_INT_MAX) {
    if ($i % 1000000 === 0) {
        echo '.';
    }
    ++$i;
}

$total = microtime(true) - $start;

$persecond = $i/$total;

echo "\nProcessed $i iterations in $total seconds ($persecond iterations per second)\n";
