<?php
/**
 *
 *
 * @author Basil Mohamed Gohar <abu_hurayrah@hidayahonline.org> on Aug 3, 2009 at 6:37:46 AM
 */

/**
 * Regular expressions for parsing different log formats.
 *
 * @var array
 */
$REGEX = array();
$REGEX['combinediovhost'] = '/^([\S]*) ([\S]*) ([\S]*) ([\S]*) \[(.*)\] "(.*)" ([\S]*) ([\S]*) "(.*)" "(.*)" ([\S]*) ([\S]*)$/';
