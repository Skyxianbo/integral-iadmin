<?php

$redis = [];

if (IS_DEV) {
    $redis = [
        'host'     => '127.0.0.1',
        'port'     => 6379,
        'password' => '', //设置为空即无需密码登录
        'database' => 0, //取值范围一般0-15
    ];
} else {
    $redis = [
        'host'     => '127.0.0.1',
        'port'     => 6379,
        'password' => '',
        'database' => 0, //取值范围一般0-15
    ];
}
