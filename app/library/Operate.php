<?php

namespace App\Library;

use Phalcon\Mvc\User\Component;

class Operate extends Component
{
    const SUCCESS = 100000; //操作成功
    const ERROR = 100001; //操作失败

    public static $info = [
        '100000' => '操作成功',
        '100001' => '操作失败',
    ];

    public static function get_info($code)
    {
        return isset(self::$info[$code]) ? self::$info[$code] : '';
    }
}
