#!/usr/bin/php

<?php

$alloptions = 'hd:n:g';

$options = getopt($alloptions);

if (empty($options) || isset($options['h'])) {
    echo "btools HDR panorama subdirectory sorter\n";
    exit;
} else {
    echo "Options passed:\n";
    print_r($options);
    if (! isset($options['d'])) {
        echo "You must pass a directory to work in\n";
        exit;
    }
    $directory = $options['d'];

    if (! isset($options['n'])) {
        echo "No number of images per segment specified\n";
        exit;
    }

    $number = $options['n'];

    if (! file_exists($directory)) {
        echo "Directory $directory does not exist!\n";
        exit;
    }

    if (! is_numeric($number) || $number <= 0) {
        echo "$number is an invalid value for number of images per segment\n";
        exit;
    }

    $dirator = new DirectoryIterator($directory);
    $image_files = array();
    $exif_pattern = '/([0-9-]+)/';
    foreach ($dirator as $file) {
        if (! $file->isFile()) {
            //  We only want to deal with files, not directories.
            continue;
        }
        $filename = $file->getPathname();
        if (IMAGETYPE_JPEG !== exif_imagetype($filename)) {
            continue;
        }
        $exif_data = exif_read_data($filename);
        $imagenumber = $exif_data['ImageNumber'];

        $image_files[$imagenumber] = $filename;
    }

    //  Sort the image filenames by their sequence number
    ksort($image_files);

    $chunked_image_files = array_chunk($image_files, $number, true);
    $total_chunks = count($chunked_image_files);
    $total_chunks_string_length = strlen($total_chunks);

    foreach ($chunked_image_files as $index => $image_files) {
        $chunk_dir = $directory . '/' . str_pad($index, $total_chunks_string_length, '0', STR_PAD_LEFT);
        //echo "$chunk_dir\n";
        mkdir($chunk_dir);
        foreach ($image_files as $image_file) {
            link($image_file, $chunk_dir . '/' . $image_file);
        }
    }
}
