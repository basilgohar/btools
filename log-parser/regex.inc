<?php

define('REGEX_COMBINEDIOVHOST', '/^([^\s]+) ([0-9.]+) (.*) (.*) \[(.+)\] "(.*)" ([0-9]+) ([0-9-]+) "(.*)" "(.*)" ([0-9-]+) ([0-9-]+)$/');
define('REGEX_COMBINED', '/^([0-9a-z.-]+) - (.+) \[(.+)\] "(.*)" ([0-9]+) ([0-9-]+) "(.*)" "(.*)"$/');
define('REGEX_COMMON', '/^([0-9a-z.-]+) - (.+) \[(.+)\] "(.*)" ([0-9]+) ([0-9-]+)$/');

$REGEX_COMBINEDIOVHOST = REGEX_COMBINEDIOVHOST;
$REGEX_COMBINED = REGEX_COMBINED;
$REGEX_COMMON = REGEX_COMMON;
