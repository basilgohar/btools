<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'lib.php';

if (isset($_REQUEST['logtext'])) {
    if ($attended_usernames = get_attended_usernames($_REQUEST['logtext'])) {
        $timestamp = date('YmdHis');
        header('Content-type: text/csv');
        header('Content-Disposition: attachment; filename="parsed-paltalk-session-' . $timestamp . '.csv"');
        foreach ($attended_usernames as $attended_username) {
            echo "$attended_username\n";
        }
    }
}
