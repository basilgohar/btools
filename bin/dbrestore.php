#!/usr/bin/php
<?php

define('BACKUP_FILENAME_SUFFIX', '_backup.sql.bz2');

if (! isset($argv[1])) {
    echo "Usage: dbrestore.php dbname\n";
    exit;
}

$filename_prefix = $argv[1];
$filename = $filename_prefix . BACKUP_FILENAME_SUFFIX;

if (! file_exists($filename)) {
    echo "Could not find a file associated with prefix '$filename_prefix'\n";
    exit;
}

$sql = "DROP DATABASE IF EXISTS `$filename_prefix`; CREATE DATABASE `$filename_prefix`;";

exec("mysql -e '$sql'");
exec("bzcat $filename | mysql $filename_prefix");
