<?php

use Phalcon\DI\FactoryDefault;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
use Phalcon\Mvc\Url as UrlResolver;
// use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Mvc\View;
use Phalcon\Session\Adapter\Files as SessionAdapter;

//缓存
// use Phalcon\Cache\Frontend\Data as FrontendData;
// use Phalcon\Cache\Backend\Memcache;
// use Phalcon\Cache\Backend\Redis;

/*
 * The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
 */
$di = new FactoryDefault();

/*
 * The URL component is used to generate all kind of urls in the application
 */
$di->set('url', function () use ($config) {
    $url = new UrlResolver();
    $url->setBaseUri($config->application->baseUri);

    return $url;
}, true);

/*
 * Setting up the view component
 */
$di->set('view', function () use ($config) {

    $view = new View();

    //关闭渲染视图
    $view->disable();

    // $view->setViewsDir($config->application->viewsDir);

    // $view->registerEngines(array(
    // '.volt' => function ($view, $di) use ($config) {

    //     $volt = new VoltEngine($view, $di);

    //     $volt->setOptions(array(
    //         'compiledPath' => $config->application->cacheDir,
    //         'compiledSeparator' => '_'
    //     ));

    //     return $volt;
    // },
    // '.php' => 'Phalcon\Mvc\View\Engine\Php'
    // ));

    return $view;
}, true);

/*
 * Database connection is created based in the parameters defined in the configuration file
 */
// $di->set('db', function () use ($config) {
//     return new DbAdapter(array(
//         'host' => $config->database->host,
//         'username' => $config->database->username,
//         'password' => $config->database->password,
//         'dbname' => $config->database->dbname
//     ));
// });

//返回响应
$di->set('response', function () {
    $response = new \Phalcon\Http\Response();

    return $response;
});

/*
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->set('modelsMetadata', function () {
    return new MetaDataAdapter();
});

/*
 * Start the session the first time some component request the session service
 */
$di->set('session', function () {
    $session = new SessionAdapter();
    $session->start();

    return $session;
});

//配置
$di->set('config', function () use ($config) {
    return $config;
});

//注册用户组件 Shared 方法会注册为单例模式
$di->set('common', function () {
    return new App\Library\Common();
}, true);

//数据库
$di->set('medoo', new App\Library\Medoo(), true);

//调度器
$di->set('dispatcher', function () {
    $dispatcher = new \Phalcon\Mvc\Dispatcher();
    // $dispatcher -> setDefaultNamespace('App\Controllers');
    return $dispatcher;
});

//路由
$di->set('router', function () {
    return require __DIR__ . '/routes.php';
});

//redis缓存
$di->set('redis', function () use ($config) {
    //默认缓存时间
    // $frontCache = new FrontendData(['lifetime' => 3]);

    //redis连接配置
    // $cache = new Redis($frontCache, [
    //     'host' => 'localhost',
    //     'port' => 6379,
    // ]);

    $redis = new Redis();
    $redis->connect($config->redis->host, $config->redis->port, 30);

    if (!empty($config->redis->password)) {
        $redis->auth($config->redis->password);
    }

    if(!empty($config -> redis -> database)){
        $redis->select($config->redis->database);
    }

    return $redis;
}, true);

//Services
$services = [
    //database
    'db_admin' => 'App\Services\Database\Admin',
    'db_mall' => 'App\Services\Database\Mall',
    'db_supplier' => 'App\Services\Database\Supplier',
    'db_distributor' => 'App\Services\Database\Distributor',

    //ali services
    'ali_oss' => 'App\Services\Ali\Oss',
    'ali_memcache' => 'App\Services\Ali\Memcache',
    'ali_redis' => 'App\Services\Ali\Redis',

    //tencent
    'tencent_wechat' => 'App\Services\Tencent\Wechat',
    'tencent_qq' => 'App\Services\Tencent\Qq',

    //other

];
foreach ($services as $k => $v) {
    $di[$k] = [
        'className' => $v,
    ];
}
