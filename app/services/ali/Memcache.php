<?php

namespace App\Services\Ali;

use App\Services\Memcached;
use App\Services\Services;

class Memcache extends Services
{
    public $connect;

    public function onConstruct($config = array())
    {
        $config = $this->config->memcached;
        $this->connect = new Memcached(); //声明一个新的memcached链接
        $this->connect->setOption(Memcached::OPT_COMPRESSION, false); //关闭压缩功能
        $this->connect->setOption(Memcached::OPT_BINARY_PROTOCOL, true); //使用binary二进制协议
        $this->connect->addServer($config['host'], $config['port']); //添加OCS实例地址及端口号
        if ($config['ocskey'] && $config['password']) {
            $this->connect->setSaslAuthData($config['ocskey'], $config['password']); //设置OCS帐号密码进行鉴权，如已开启免密码功能，则无需此步骤
        }
    }

    public function set($key, $data, $expire = 180)
    {
        return $this->connect->set($key, $data, $expire);
    }

    public function get($key)
    {
        return $this->connect->get($key);
    }

    public function delete($key)
    {
        return $this->connect->delete($key);
    }
}
