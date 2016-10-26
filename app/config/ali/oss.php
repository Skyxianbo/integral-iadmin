<?php
//阿里云OSS配置
$oss = [];

//开发环境
if (IS_DEV) {
    $oss = [
        'oss_access_id'    => '',
        'oss_access_key'   => '',

        'key_id'           => '',
        'key_secret'       => '',
        'role_arn'         => '',
        'expire'           => 3600, //过期时间（秒），阿里云允许的范围900-3600
        'url'              => 'https://sts.aliyuncs.com', //STS请求地址
        'format'           => 'JSON', //返回格式：JSON、XML

        'bucket'           => '',
        'host_name'        => 'oss-cn-hangzhou.aliyuncs.com',
        'img_host_name'    => 'img-cn-hangzhou.aliyuncs.com',

        'dev_outline_host' => '',

        //路径
        'path'             => [
            'avatar' => 'test/avatar/',
        ],
    ];
} else {
    $oss = [
        'oss_access_id'    => '',
        'oss_access_key'   => '',

        'key_id'           => '',
        'key_secret'       => '',
        'role_arn'         => '',
        'expire'           => 3600, //过期时间（秒），阿里云允许的范围900-3600
        'url'              => 'https://sts.aliyuncs.com', //STS请求地址
        'format'           => 'JSON', //返回格式：JSON、XML

        'bucket'           => '',
        'host_name'        => 'oss-cn-hangzhou.aliyuncs.com',
        'img_host_name'    => 'img-cn-hangzhou.aliyuncs.com',

        'dev_outline_host' => '',

        //路径
        'path'             => [
            'avatar' => 'avatar/',
        ],
    ];
}

$oss['http_img_host'] = 'http://' . $oss['bucket'] . '.' . $oss['img_host_name'];
