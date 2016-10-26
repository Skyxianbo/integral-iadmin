<?php

//阿里服务配置
include 'ali/database.php';
include 'ali/oss.php';
include 'ali/memcached.php';
include 'ali/redis.php';

//腾讯服务配置
include 'tencent/wechat.php';
include 'tencent/qq.php';

//系统配置
include 'application.php';

return new \Phalcon\Config(array(
    'database'    => $database,
    'application' => $application,
    'oss'         => $oss,
    'memcached'   => $memcached,
    'redis'       => $redis,
    'wechat'      => $wechat,
    'qq'          => $qq,
));
