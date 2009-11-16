#!/usr/bin/php
<?php
/**
 * Script to parse an httpd access log in combinediovhost format and insert into
 * a database
 *
 * @author Basil Mohamed Gohar <abu_hurayrah@hidayahonline.org> on Jul 26, 2009 at 7:35:17 AM
 */

require_once 'zf-setup.inc';

$helptext = 'Access Log to DB script
Copyright (c) 2009 Basil Mohamed Gohar <abu_hurayrah@hidayahonline.org>

USAGE: access-log-to-db.php [options] logfile

Description of options:
    -h  display this help screen
    -f  specify log file format (currently ignored)
    -u  specify username for database to received log records
    -p  password for database user
    -n  hostname for database
    -d  database name
    -l  log filename
';

$REGEX = '/^([\S]*) ([\S]*) ([\S]*) ([\S]*) \[(.*)\] "(.*)" ([\S]*) ([\S]*) "(.*)" "(.*)" ([\S]*) ([\S]*)$/';

$shortoptions = '';
$shortoptions .= 'h';   //  Display help
$shortoptions .= 'f:';  //  Specify log format to use
$shortoptions .= 'u:';  //  Database username
$shortoptions .= 'p:';  //  Database password
$shortoptions .= 'n:';  //  Database hostname
$shortoptions .= 'd:';  //  Database name
$shortoptions .= 'l:';  //  Log filename

$options = getopt($shortoptions);

if (isset($options['h'])) {
    //  print help & exit
    echo $helptext;
    exit;
}

if (! isset($options['l'])) {
    echo "ERROR: No log file specified\n";
    echo $helptext;
    exit;
}

if (! file_exists($options['l'])) {
    exit('Invalid log file specified');
}

if (! $fp = fopen($options['l'], 'r')) {
    exit('Could not open log file specified');
}

/**
 * Maps array element names to the index of the $matches array from preg_match
 *
 * @var array $varnames
 */
$varnames = array(
    1  => 'virtualhost',
    2  => 'ipaddress',
    5  => 'timestamp',
    6  => 'request',
    7  => 'responsecode',
    8  => 'length',
    9  => 'referer',
    10 => 'useragent',
    11 => 'bytesinput',
    12 => 'bytesoutput'
);

$sql = '';

while (false !== ($line = fgets($fp))) {
    $return = preg_match($REGEX, $line, $matches);
    if (1 === $return) {
        foreach ($varnames as $index => $name) {
            $$name = $matches[$index];
            /*
            $virtualhost = $matches[1];
            $ipaddress = $matches[2];
            $timestamp = $matches[5];
            $request = $matches[6];
            $responsecode = $matches[7];
            $length = $matches[8];
            $referer = $matches[9];
            $useragent = $matches[10];
            $bytesinput = $matches[11];
            $bytesoutput = $matches[12];
            */
        }
        $values_array = array();
        foreach ($varnames as $name) {
            $filtered_value = '';
            switch ($name) {
                default:
                    if ('-' === $$name) {
                        $filtered_value = '';
                    } else {
                        $filtered_value = $$name;
                    }
                    break;
                case 'ipaddress':
                    $filtered_value = sprintf('%u', ip2long($$name));
                    break;
                case 'timestamp':
                    $filtered_value = strtotime($$name);
                    break;
            }
            $values_array[$name] = $filtered_value;
        }
        if (0 === strlen($sql)) {
            $sql = "INSERT INTO `aalimraan` (`" . implode('`,`', $varnames) . "`) VALUES ('" . implode("','", $values_array) ."')";
        } else {
            $sql .= ",('" . implode("','", $values_array) . "')";
        }
        echo "$sql\n";
    } else if (0 === $return) {
        echo $line;
    } else {
        echo "An error has occurred\n";
        exit;
    }
}
