<?php

namespace App\Services\Tencent;

use App\Services\Services;

/**
 * 微信服务
 */
class Qq extends Services
{
    public function qq_user_info($uid, $access_token)
    {
        $qq = $this->config->qq;

        $url = $qq->base_url . 'user/get_user_info';
        $params = [
            'access_token' => $access_token,
            'openid' => $uid,
            'oauth_consumer_key' => $qq['appid'],
        ];
        $result = json_decode($this->common->curl_get($url, $params), true);
        if ($result['ret'] == 0) {
            $result['openid'] = $uid;
            $result['sex'] = $result['gender'];
            $result['headimgurl'] = $result['figureurl_qq_2'];
            $result['country'] = '';
            $result['privilege'] = '';
            $result['unionid'] = '';
            $result['language'] = '';

            unset($result['ret'], $result['msg'], $result['is_lost'], $result['figureurl'], $result['figureurl_1'], $result['figureurl_2'], $result['figureurl_qq_1'], $result['figureurl_qq_2'], $result['is_yellow_vip'], $result['vip'], $result['yellow_vip_level'], $result['level'], $result['is_yellow_year_vip']);

            return $result;
        }

        return false;
    }
}
