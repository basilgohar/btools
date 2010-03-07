<?php
/**
 *
 *
 * @author Basil Mohamed Gohar <abu_hurayrah@hidayahonline.org> on Aug 3, 2009 at 6:33:13 AM
 */

require 'config.inc';

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

require 'lib.inc';
