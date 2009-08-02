<?php
/**
 *
 *
 * @author Basil Mohamed Gohar <abu_hurayrah@hidayahonline.org> on Aug 2, 2009 at 8:05:24 PM
 */

/**
 * Zend Framework initialization
 */
define('ZEND_FRAMEWORK_PATH', '/usr/share/php/Zend');

$database = array(
    'adapter' => 'pdo_mysql',
    'params'  => array(
        'host'     => 'localhost',
        'dbname'   => '',
        'username' => '',
        'password' => '',
    )
);