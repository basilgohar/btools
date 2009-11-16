<?php

require_once 'setup.inc';

set_include_path(get_include_path() . PATH_SEPARATOR . ZEND_FRAMEWORK_PATH);

require 'Zend/Loader.php';

Zend_Loader::registerAutoload();

$config = new Zend_Config(
    array(
        'database' => $database
    )
);

$db = Zend_Db::factory($config->database);

Zend_Db_Table::setDefaultAdapter($db);
