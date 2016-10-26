<?php

namespace App\Services\Ali;

use App\Services\Services;

class Redis extends Services
{
    public function set($key, $value, $expire = 180)
    {
        return $this->redis->setex($key, $expire, json_encode($value));
    }

    public function get($key)
    {
        return json_decode($this->redis->get($key), true);
    }

    public function delete($key)
    {
        return $this->redis->delete($key);
    }
}
