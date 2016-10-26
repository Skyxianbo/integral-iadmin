<?php

use Phalcon\Mvc\Router;
use Phalcon\Mvc\Router\Group as RouterGroup;

$list = [
    //路由分组
    'v1' => [
        'group' => [
            'namespace' => 'App\Controllers',
        ],
        'prefix' => '',
        'router' => [

            //Test
            '/test' => 'Test::index',

            //Admin

            //Mall

            //Supplier

            //Distributor

];

//路由
$router = new Router();

foreach ($list as $item) {
    if (!isset($item['router']) || !$item['router']) {
        continue;
    }

    //路由分组
    $group = new RouterGroup($item['group']);
    $group->setPrefix($item['prefix']);

    //注册路由
    foreach ($item['router'] as $k => $v) {
        $group->add($k, $v);
    }

    //挂载路由分组
    $router->mount($group);
}

//删除后置斜杠
$router->removeExtraSlashes(true);
//找不到页面跳转
$router->notFound('Error::notFound');
//设置默认命名空间
$router->setDefaultNamespace('App\Controllers');
//默认路由
$router->add('/', 'Error::notFound');

return $router;
