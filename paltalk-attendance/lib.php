<?php

function get_parsed_usernames_and_text($logtext)
{
    $pattern = '/(.+): (.+)/';
    $raw_log_array = explode("\n", $logtext);
    $log_array = array();
    foreach ($raw_log_array as $raw_log_row) {
        $log_array[] = trim($raw_log_row);
    }
    $parsed_log_array = array();
    foreach ($log_array as $log_row) {
        $matches = array();
        if (preg_match($pattern, $log_row, $matches)) {
            list(, $username, $text) = $matches;
            $parsed_log_array[] = array('username' => $username, 'text' => $text);
        }
    }
    return $parsed_log_array;
}

function get_attended_usernames($logtext)
{
    $attendance_started = false;
    $attended_usernames = array();
    $parsed_log_array = get_parsed_usernames_and_text($logtext);
    foreach ($parsed_log_array as $parsed_log_row) {
        $username = $parsed_log_row['username'];
        $text = $parsed_log_row['text'];
        if (false !== (strpos(strtolower($text), 'attend'))) {
            //  Attendance has started.
            $attendance_started = true;
            //  The moderator doesn't need his or her attendance logged. ;)
            continue;
        }
        if (! $attendance_started) {
            //  Skip this log text.
            continue;
        }
        if (false !== (strpos($text, '1'))) {
            $attended_usernames[] = $username;
        }
    }
    return $attended_usernames;
}
