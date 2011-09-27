<?php
date_default_timezone_set('Europe/Moscow');
// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));
$test = realpath(APPLICATION_PATH . '/../library');
/** Zend_Application */
require_once 'Zend/Application.php';

require_once 'Zend/Loader/Autoloader.php';
$load = Zend_Loader_Autoloader::getInstance();
// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);

$front = Zend_Controller_Front::getInstance();

$application->bootstrap()
            ->run();
  