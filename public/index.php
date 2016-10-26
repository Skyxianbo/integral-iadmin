<?php

date_default_timezone_set('PRC');

define('IS_DEV', $_SERVER['SERVER_ADDR'] == '120.26.130.63' || $_SERVER['SERVER_NAME'] == 'test.api.justtong.com');
define('APP_DEBUG', false);

define('APP_PATH', realpath('..') . '/');
define('VENDOR_PATH', APP_PATH . 'app/vendor/');

//开发环境显示错误
if (IS_DEV) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
}

try {

    /*
     * Read the configuration
     */
    $config = include __DIR__ . '/../app/config/config.php';

    /**
     * Read auto-loader.
     */
    include __DIR__ . '/../app/config/loader.php';

    /**
     * Read services.
     */
    include __DIR__ . '/../app/config/services.php';

    /*
     * Handle the request
     */
    $application = new \Phalcon\Mvc\Application($di);

    echo $application->handle()->getContent();
} catch (\Exception $e) {
    if (IS_DEV) {
        echo get_class($e), ': ', $e->getMessage(), '<br>',
        ' File=', $e->getFile(), '<br>',
        ' Line=', $e->getLine(), '<br>',
        $e->getTraceAsString();
    } else {
        echo 'ol';
    }
}
