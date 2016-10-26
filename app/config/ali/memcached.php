<?php

$memcached = [];

if (IS_DEV) {
    $memcached = [
        'prefix'   => 'api_test_',
        'host'     => '127.0.0.1',
        'port'     => '11211',
        'ocskey'   => '',
        'password' => '',
    ];
} else {
    $memcached = [
        'prefix'   => 'api_',
        'host'     => '127.0.0.1',
        'port'     => '11211',
        'ocskey'   => '',
        'password' => '',
    ];
}
