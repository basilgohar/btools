#!/usr/bin/php
<?php

if (isset($argv[1]) && ('go' === $argv[1])) {
    $teeth = true;
} else {
    $teeth = false;
}

if (! $teeth) {
    echo "== Dry run - no files will be changed ==\n";
}

$cwd = getcwd();

$dir = new DirectoryIterator($cwd);

$file_array = array();

foreach ($dir as $file) {
    if ($file->isFile()) {
        $file_array[] = array('name' => $file->getFilename(), 'time' => $file->getMTime(), 'type' => 'image/jpeg');
    }
}

$file_array_count = count($file_array);

reset($file_array);

$keys = array_keys(current($file_array));

foreach($keys as $key) {
    $$key = array();
}

foreach ($file_array as $file_row) {
    foreach ($file_row as $key => $value) {
        ${$key}[] = $value;
    }
}

array_multisort(${$keys[1]}, SORT_ASC, ${$keys[0]}, SORT_ASC, $file_array);

$index = 1;

$digits = strlen($file_array_count);

foreach ($file_array as $key => $file_row) {
    $file_array[$key]['rename'] = str_pad($index++, $digits, '0', STR_PAD_LEFT);
}

foreach ($file_array as $file_row) {
    $pathinfo = pathinfo($file_row['name']);
    $new_filename = "{$file_row['rename']}.{$pathinfo['extension']}";
    echo "{$file_row['name']}\t$new_filename\n";
    if ($teeth) {
        rename($file_row['name'], $new_filename);
    }
}

if (! $teeth) {
    echo "== Dry run - no files were changed ==\n";
}
