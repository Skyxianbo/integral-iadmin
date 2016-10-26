<?php

namespace App\Library;

use Phalcon\Logger\Adapter\File as FileAdapter;
use Phalcon\Mvc\User\Component;

/**
 * 全局通用方法类，调用方式 $this -> common -> full_date();
 * 接口通用方法请写在 App\Controllers\BaseController 下.
 */
class Common extends Component
{
    //通用类的测试方法
    public function test()
    {
        $this->redis->set('123', 456);
        var_dump($this->redis->get('123'));
    }

    //完整日期
    public function full_date($intval = 0)
    {
        return $intval ? date('Y-m-d H:i:s', $intval) : date('Y-m-d H:i:s');
    }

    //短日期
    public function short_date($intval = 0)
    {
        return $intval ? date('Y-m-d', $intval) : date('Y-m-d');
    }

    //POST请求
    public function curl_post($url, $param = [])
    {
        return $this->curl($url, $param, 'post');
    }

    //GET请求
    public function curl_get($url, $param = [])
    {
        return $this->curl($url, $param, 'get');
    }

    /**
     * CURL 会话.
     *
     * @param $url 请求地址
     * @param $param 请求参数
     * @param $method 请求方法：GET、POST
     * @param $content_type 类型，默认JSON
     * @param $flag 是否从服务端进行验证，默认不验证
     */
    public function curl($url, $param = array(), $method = 'post', $content_type = 'application/json', $flag = 0)
    {
        $ch = curl_init(); //初始化
        if (!$flag) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //不从服务端进行验证
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //将 curl_exec() 获取的信息以文件流的形式返回，而非直接输出

        if (strtolower($method) == 'post') {
            //如果是POST请求

            curl_setopt($ch, CURLOPT_POST, true); //POST请求
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($param)); //POST参数
        } else {
            //如果是GET请求

            $url .= '?' . http_build_query($param); //组合URL字符串
        }
        curl_setopt($ch, CURLOPT_URL, $url); //请求的URL地址

        //头部信息
        $header = [
            'Content-Type: ' . $content_type,
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header); //传入头部信息

        $ret = curl_exec($ch); //执行
        curl_close($ch); //关闭会话

        return $ret; //返回结果
    }

    //生成GUID
    public function create_guid()
    {
        return strtolower(md5(uniqid(mt_rand(), true)));
    }

    //PHP自带的getallheaders方法在nginx环境下不可用
    public function get_all_headers()
    {
        $headers = '';
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
        }

        return $headers;
    }

    //获取IP
    public function get_ip($flag = true)
    {
        if ($flag && !empty($_POST['ip'])) {
            return $_POST['ip'];
        }

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (!empty($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        } else {
            $ip = 'unknow';
        }

        return $ip;
    }

    //返回数组中值 if($value) 的参数
    public function array_filter_return_true($arr)
    {
        if (!is_array($arr)) {
            return false;
        }

        return array_filter($arr, function ($v) {
            if ($v) {
                return $v;
            }
        });
    }

    //获取毫秒级的时间戳，返回1234567890123
    public function microtime()
    {
        list($s1, $s2) = explode(' ', microtime());
        return (float) sprintf('%.0f', (floatval($s1) + floatval($s2)) * 1000);
    }

    //获取OSS上传对象的名字：YYYYmmdd + md5(microtime, 16) + random_number(6) + ext
    public function oss_unique_name($ext = 'jpg') //ext扩展名取值：jpg、mp3、mp4
    {
        return date('Ymd') . substr(md5($this->micro_time()), 8, 16) . mt_rand(100000, 999999) . '.' . $ext;
    }

    /**
     * 调试日志
     * @param  [type] $log_data 输出内容
     * @param  string $log_type critical
     *                          emergency
     *                          debug
     *                          error
     *                          info
     *                          notice
     *                          warning
     *                          alert
     * @return [type]           [description]
     */
    public function send_log($log_data, $log_type = 'debug')
    {
        $log_path = __DIR__ . '/../../logs/api_debug/';
        //die($log_path);
        $log_file = date('Y-m-d', time()) . '.log';
        if (!is_dir($log_path)) {
            //第三个参数是“true”表示能创建多级目录
            mkdir($log_path, 0777, true);
        }
        $logger = new FileAdapter($log_path . $log_file);

        $content = json_encode($log_data);
        if ($log_type == 'alert') {
            $content = date('Y-m-d H:i:s', time()) . ' Alert message:' . $content;
        }

        $logger->$log_type($content);
    }

    //调试输出日志
    public function debug()
    {
        $this -> send_log(func_get_args(), 'debug');
    }

    //处理pages和rows
    public function get_page_info($pages_default_vaule = 1, $rows_default_value = 10)
    {
        return [
            isset($_REQUEST['pages']) && ($pages = intval($_REQUEST['pages'])) > 0 ? $pages : $pages_default_vaule,
            isset($_REQUEST['rows']) && ($rows = intval($_REQUEST['rows'])) > 0 ? $rows : $rows_default_value,
        ];
    }

    //验证用户名，邮箱，手机号
    public function check($type, $value)
    {
        if (!$value) {
            return false;
        }
        switch ($type) {
            case 'email': //邮箱
                return preg_match("/^[0-9a-zA-Z_]+@(([0-9a-zA-Z]+)[.])+[a-z]{2,4}$/i", $value);
            case 'phone': //手机号（不完善）
                return preg_match("/^1[34578][0-9]{9}$/", $value);
            case 'username': //中文用户名
                return preg_match("/^[A-Za-z0-9\x{4e00}-\x{9fa5}]+$/u", $value);
            case 'postcode': //邮编
                return strlen($value) == 6 && is_int($value - 0);
            default:
                return false;
        }
    }
}
