#!/usr/bin/php
<?php

require_once 'regex.inc';

$helptext = 'Access Log to DB script
Copyright (c) 2009 Basil Mohamed Gohar <abu_hurayrah@hidayahonline.org>

USAGE: access-log-stats.php [options] logfile

';

if (! isset($argv[1])) {
    echo $helptext;
    exit;
}

if (! file_exists($argv[1])) {
    echo "File {$argv[1]} does not exist!\n";
    exit;
}

if (! $fp = fopen($argv[1], 'r')) {
    echo "Cannot read {$argv[1]}\n";
    exit;
}

$referers_requests = array();

while (false !== ($line = fgets($fp))) {
    if (! preg_match($REGEX_COMBINEDIOVHOST, $line, $matches)) {
        echo "$line\n";
    } else {
        $referer = $matches[9];
        $referers_requests[$referer][] = $matches[6];
    }
}

print_r($referers_requests);
