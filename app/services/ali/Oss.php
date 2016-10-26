<?php

namespace App\Services\Ali;

use App\Services\Services;

require_once VENDOR_PATH . 'oss2/autoload.php';

use OSS\Core\OssException;
use OSS\OssClient;

class Oss extends Services
{
    //从redis中获取sts token，若redis没有，则向阿里oss请求
    public function get_sts_token_by_redis()
    {
        $key = 'alioss_sts_token';
        $data = json_decode($this->redis->get($key), true);

        if (!$data || $data['expire_time'] < time() + 300) {
            $result = json_decode($this->get_sts_token(), true)['Credentials'];

            if ($result === null) {
                return [];
            }

            $data = [
                'bucket' => $this->config->oss->bucket,
                'host_name' => $this->config->oss->host_name,
                'img_host_name' => $this->config->oss->img_host_name,
                'key_id' => $result['AccessKeyId'],
                'key_secret' => $result['AccessKeySecret'],
                'security_token' => $result['SecurityToken'],
                'expire_time' => strtotime($result['Expiration']),
            ];

            $this->redis->set($key, json_encode($data));
        }

        return $data;
    }

    //即时获取sts token
    public function get_sts_token()
    {
        //请求参数
        $params = [
            //公共参数
            'Format' => $this->config->oss->format,
            'Version' => '2015-04-01',
            'AccessKeyId' => $this->config->oss->key_id,
            'SignatureMethod' => 'HMAC-SHA1',
            'SignatureVersion' => '1.0',
            'SignatureNonce' => uniqid('_request_', true),
            'Timestamp' => str_replace(' ', 'T', date('Y-m-d H:i:s', time() - 8 * 3600) . 'Z'),

            //接口参数
            'Action' => 'AssumeRole',
            'RoleArn' => $this->config->oss->role_arn,
            'RoleSessionName' => 'sts',
            'DurationSeconds' => $this->config->oss->expire,
            // 'Policy' => '',
        ];

        ksort($params);

        //签名
        $string_to_sign = 'GET&' . urlencode('/') . '&' . urlencode(http_build_query($params));

        //把签名加入请求参数中
        $params['Signature'] = base64_encode(hash_hmac('sha1', $string_to_sign, $this->config->oss->key_secret . '&', true));

        return $this->common->curl_get($this->config->oss->url, $params);
    }

    //上传单个图片到OSS
    public function upload_single($oss_path, $local_file, $filename)
    {
        // $token = $this -> get_sts_token(); //即时获取
        $token = $this->get_sts_token_by_redis(); //每55分钟获取

        if (!$token) {
            return '';
        }

        try {
            $ossClient = new OssClient($token['key_id'], $token['key_secret'], $token['host_name'], false, $token['security_token']);
        } catch (OssException $e) {
            return '';
            // return strval($e -> getMessage());
        }

        $options = [];

        try {
            $ossClient->uploadFile($token['bucket'], $oss_path, $local_file, $options);
        } catch (OssException $e) {
            return '';
            // return strval($e -> getMessage());
        }

        return $this->config->oss->http_img_host . '/' . $oss_path;
    }
}
