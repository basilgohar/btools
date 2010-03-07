#!/usr/bin/php
<?php

if (! isset($argv[1])) {
	die("No file specified\n");
}

if (! is_file($argv[1])) {
	die("'{$argv[1]}' is not a valid file name\n");
}

if (! $fp = fopen($argv[1], 'r')) {
	die("Could not open file '{$argv[1]}'\n");
}

$delete_files = false;

if (isset($argv[2]) && 'go' === $argv[2]) {
	$delete_files = true;
}

while ($line = fgets($fp)) {
	if (! is_file(trim($line))) {
		echo trim($line) . " is not a valid file!\n";
	}

	if ($delete_files) {
		echo "Deleting file '" . trim($line) . "'...";
		if (unlink(trim($line))) {
			echo "Deleted!\n";
		} else {
			echo "Could not delete!\n";
		}
	} else {
		echo "Not in delete mode, will not delete file '" . trim($line) . "'\n";
	}
}
