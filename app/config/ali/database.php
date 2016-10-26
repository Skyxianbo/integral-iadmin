<?php
//数据库配置
$database = [];

//开发环境
if (IS_DEV) {
    $database = [
        'dbtype'   => 'mysql',
        'host'     => '127.0.0.1',
        'port'     => '3306',
        'username' => 'root',
        'password' => '123456',
        'dbname'   => '',
        'prefix'   => '',
        'charset'  => 'utf8mb4', //支持emoji，勿改
    ];
} else {
    $database = [
        'dbtype'   => 'mysql',
        'host'     => '127.0.0.1',
        'port'     => '3306',
        'username' => 'root',
        'password' => '123456',
        'dbname'   => '',
        'prefix'   => '',
        'charset'  => 'utf8mb4', //支持emoji，勿改
    ];
}
