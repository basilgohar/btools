#!/usr/bin/php
<?php

if (isset($argv[1]) && is_dir($argv[1])) {
    //  Use the directory that was given as an argument
    $directory_path = $argv[1];
} else {
    //  User the default directorry path
    $directory_path = '.';
}

chdir($directory_path);

$dir = new DirectoryIterator('.');

//  This is the pattern to extract the unique, in-order sequence number of the image
$exif_pattern = '/([0-9-]+)/';

$image_files = array();
foreach ($dir as $file) {
    if (! $file->isFile()) {
        //  We only want to deal with files, not directories.
        continue;
    }
    $image_extension = '.jpg';
    $filename = $file->getFilename();
    if (false === strpos(strtolower($filename), $image_extension, strlen($filename) - (strlen($image_extension) + 1))) {
        //  These aren't the droids, erm, files we're looking for.
        continue;
    }
    //  Grab the unique and in-order sequence number of the image file
    $exif_filenumber_raw = `exiftool -FILENUMBER $filename`;
    $matches = array();
    preg_match($exif_pattern, $exif_filenumber_raw, $matches);
    //  Extract the number from the raw output
    $exif_filenumber = $matches[1];
    //  Add the image, keyed to its sequence number, to the array
    $image_files[$exif_filenumber] = $filename;
}

//  Sort the image filenames by their sequence number
ksort($image_files);

//  Now we will loop through the ordered images, alternatively putting the images at the beginning and end of the final array, going from dark to light

$light_or_dark = null;
$image_files_by_brightness = array();

foreach ($image_files as $image_file) {
    switch ($light_or_dark) {
        default:
            //break;
        case null:
            $light_or_dark = 'light';
            $image_files_by_brightness[0] = $image_file;
            break;
        case 'light':
            $light_or_dark = 'dark';
            $image_files_by_brightness[min(array_keys($image_files_by_brightness)) - 1] = $image_file;
            break;
        case 'dark':
            $light_or_dark = 'light';
            $image_files_by_brightness[max(array_keys($image_files_by_brightness)) + 1] = $image_file;
            break;
    }
}

krsort($image_files_by_brightness);

print_r($image_files_by_brightness);

if (isset($argv[2]) && 'go' === $argv[2]) {
    mkdir('ordered');
    chdir('ordered');

    $index = 0;

    foreach ($image_files_by_brightness as $image_file) {
        link("../$image_file", str_pad($index, 2, '0', STR_PAD_LEFT) . '.jpg');
        ++$index;
    }
}
