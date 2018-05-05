#!/usr/bin/env php
<?php

if (! isset($argv[1])) {
	exit('No file passed as argument.');
}

if (! file_exists($argv[1])) {
	exit('Specified file does not exist!');
}

$caps = file_get_contents($argv[1]);

$parsed_caps = str_replace('; ', "\n", $caps);

echo $parsed_caps;
