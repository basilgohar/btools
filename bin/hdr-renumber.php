#!/usr/bin/php
<?php

$dir = new DirectoryIterator('.');

$filenames = array();

foreach ($dir as $file) {
    if (! $file->isFile()) {
        continue;
    }
    $filename = $file->getFilename();
    if (false === strpos($filename, '.jpg')) {
        continue;
    }
    $filenames[] = $filename;
}

sort($filenames);

$reordered_filenames = array();

$next_state = 'first';

foreach ($filenames as $filename) {
    switch ($next_state) {
        case 'first':
            $reordered_filenames[0] = $filename;
            $next_state = 'light';
            break;
        case 'light':
            $reordered_filenames[max(array_keys($reordered_filenames)) + 1] = $filename;
            $next_state = 'dark';
            break;
        case 'dark':
            $reordered_filenames[min(array_keys($reordered_filenames)) - 1] = $filename;
            $next_state = 'light';
    }
}

ksort($reordered_filenames);
print_r($reordered_filenames);

if (isset($argv[1]) && 'go' === $argv[1]) {
    mkdir('ordered');
    chdir('ordered');

    $index = 0;
    foreach ($reordered_filenames as $filename) {
        link('../' . $filename, str_pad($index, 2, '0', STR_PAD_LEFT) . '.jpg');
        ++$index;
    }
}
