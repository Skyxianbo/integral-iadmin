<?php

namespace App\Services\Tencent;

use App\Services\Services;

require_once VENDOR_PATH . 'wxpay/WxPay.Api.php';

/**
 * 微信服务
 */
class Wechat extends Services
{
    public function get_access_token($refresh_token)
    {
        $wechat = $this->config->wechat;

        $params = [
            'appid' => $wechat->appid,
            'grant_type' => 'refresh_token',
            'refresh_token' => $refresh_token,
        ];

        $result = $this->common->curl_get($wechat->base_url . 'sns/oauth2/refresh_token', $params);
        $token = json_decode($result, true);

        return isset($token['access_token']) ? $token['access_token'] : null;
    }

    public function wechat_user_info($uid, $access_token)
    {
        $wechat = $this->config->wechat;

        $params = [
            'access_token' => $access_token,
            'openid' => $uid,
        ];

        $result = json_decode($this->common->curl_get($wechat->base_url . 'sns/userinfo', $params), true);
        if ($result['headimgurl']) {
            $result['year'] = '';
        }

        return $result;
    }

    public function wxpay_unified_order($trade_no, $member_id, $child_id, $recommend_package_id, $recommend_package_name, $price, $notify_url, $body)
    {
        $trade_type = 'APP';

        $input = new \WxPayUnifiedOrder();
        $input->SetBody($body);
        $input->SetAttach('test');
        $input->SetOut_trade_no($trade_no);
        $input->SetTotal_fee($price);
        $input->SetTime_start(date('YmdHis'));
        $input->SetTime_expire(date('YmdHis', time() + 301));
        $input->SetNotify_url($notify_url);
        $input->SetTrade_type($trade_type);

        return \WxPayApi::unifiedOrder($input);
    }
}
