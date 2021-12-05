<?php

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../../application'));

// Define path to library directory
defined('LIBRARY_PATH')
    || define('LIBRARY_PATH', realpath(__DIR__ . '/../../library'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'testing'));

// Define zend framework environement (zend_env.ini in config directory)
$zend_env = parse_ini_file(realpath(__DIR__ . '/../../application/configs/zend_env.ini'), false);
// Define path to zend files
defined('ZEND_PATH')
    || define('ZEND_PATH', $zend_env['path.zend']);

// Ensure everything is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(LIBRARY_PATH),
    realpath(APPLICATION_PATH),
    realpath(ZEND_PATH),
    get_include_path(),
)));

/** Zend_Application */
require_once 'Zend/Application.php';
require_once 'ModelTestCase.php';
// Create application, bootstrap, and run
$application = new Zend_Application(
   APPLICATION_ENV,
   APPLICATION_PATH . '/configs/application.ini'
);
//$application->bootstrap();
clearstatcache();

