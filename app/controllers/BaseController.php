<?php

namespace App\Controllers;

use App\Library\Operate;
use Phalcon\Mvc\Controller;

/**
 * 所有 API 父类.
 */
class BaseController extends Controller
{
    //此方法等同于 __construct，Phalcon中无法直接使用 __construct会报错
    public function initialize()
    {
        $allow_headers = [
            'Content-Type',
            'Accept',
            'Authorization',
            'X-Requested-With',

            //如有其它头请加在这里
            'Token-Key',
            'Token-Secret',
        ];

        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
        header('Access-Control-Allow-Headers: ' . implode(', ', $allow_headers));

        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            header('HTTP/1.1 200 OK');
            exit;
        }
    }

    // ====================================================================================
    // ====================================================================================
    // ====================================================================================
    // ====================================================================================
    // ====================================================================================
    // ====================================================================================
    // ====================================================================================
    // ====================================================================================
    // 所有 API 通用方法

    //返回json数据并终止程序
    public function exit_json($status = Operate::SUCCESS, $info = '', $data = '')
    {
        if (empty($info)) {
            $info = Operate::get_info($status);
        }

        $result = [
            'status' => $status,
            'info' => $info,
            'data' => $data,
            'timestamp' => time(),
        ];

        header('Content-Type: application/json; charset=UTF-8');
        exit(json_encode($result));
    }

    //验证POST传参
    public function check_post($array)
    {
        if (!is_array($array)) {
            return '参数必须是数组';
        }
        $params = [];
        foreach ($array as $v) {
            if (!isset($_POST[$v])) {
                $params[] = $v;
            }
        }

        if ($params) {
            $this->exit_json(Operate::PARAM_ERROR, implode(', ', $params));
        }

        return true;
    }

    //验证header传参
    public function check_header($is_login = true)
    {
        if ($is_login) {
            $header_arr = [

            ];
        } else {
            $header_arr = [

            ];
        }

        $header = $this->common->get_all_headers();

        $params = [];
        foreach ($header_arr as $v) {
            if (!isset($header[$v])) {
                $params[] = $v;
            }
        }

        if ($params) {
            $this->exit_json(Operate::PARAM_ERROR_HEADER, implode(', ', $params));
        }

        return true;
    }
}
