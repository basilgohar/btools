#!/usr/bin/php
<?php
/**
 * Find files that are missing or corrupted from one location and grab them from
 * another
 *
 * @author Basil Mohamed Gohar <abu_hurayrah@hidayahonline.org> on Sep 4, 2009 at 8:10:16 PM
 */

$source_path = '/media/WD320GB/photos';
$destination_path = '/media/SGB7200.11500GB/Pictures/time-lapse/Kuala Terengganu/car-ride-1';

$source_directory = new DirectoryIterator($source_path);
$destination_directory = new DirectoryIterator($destination_path);

//  This is the pattern to extract the unique, in-order sequence number of the image
$exif_pattern = '/([0-9-]+)/';

$image_files = array();

foreach ($destination_directory as $file) {
    if ($file->isDir()) {
        //  Not a file
        continue;
    }
    if (0 === $file->getSize()) {
        //  File has length of zero
        continue;
    }
    $pathname = $file->getPathname();
    if ('jpg' !== substr($pathname, -3)) {
        //  Not a JPEG file
        continue;
    }
    //  Grab the unique and in-order sequence number of the image file
    $exif_filenumber_raw = `exiftool -FILENUMBER '$pathname'`;
    $matches = array();
    preg_match($exif_pattern, $exif_filenumber_raw, $matches);
    //  Extract the number from the raw output
    $exif_filenumber = $matches[1];
    //  Add the image, keyed to its sequence number, to the array
    $image_files[$exif_filenumber] = $pathname;
}

ksort($image_files);

var_dump($image_files);
