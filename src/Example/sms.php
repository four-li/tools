<?php

include_once __DIR__ . '/../../vendor/autoload.php';

$appId     = '';
$appkey    = '';
$smsSign   = '';
$templates = ['验证码' => 377741, '通知' => 377742];

##### 腾讯短信 #####
$client = new \FourLi\Tools\Sms\Tencent\Client(
    $appId,
    $appkey,
    $smsSign,
    $templates
);

//$ret = $client->useTemplate('验证码')->singleSend(13971777435, [123453]);

##### 阿里大于 #####
$key_id      = '';
$key_secret  = '';
$smsSign     = '';
$templates   = [
    '撤销通知' => ''
];
$client      = new \FourLi\Tools\Sms\ALiYun\Client($key_id, $key_secret, $smsSign, $templates);
$customParam = ["string" => 'test'];
//$ret         = $client->useTemplate('')->singleSend(13971777435, $customParam);

# 容联
$accountSid   = '';
$accountToken = '';
$appId        = '';
$templates    = [
    '店铺提醒通知' => 457569,
    '验证码'    => 456764,
    '付款成功'   => 456763,
    '活动提醒'   => 456762,
    '提醒签到'   => 456761,
    '购买成功'   => 456760,
    '登录成功'   => 456759,
    '预约失败'   => 456758,
    '预约成功'   => 456757,
    '注册'     => 456756,
];

$client = new \FourLi\Tools\Sms\RongLian\Client($accountSid, $accountToken, $appId, $templates);

//$ret = $client->useTemplate('验证码')->singleSend(13971777435, ['verifyCode']);

##### 祝通科技 #####
$USERNAME = '';
$PASSWORD = '';
$TEMPLATE = ['验证码' => '【xx公司】您的验证码为：'];

$client = new \FourLi\Tools\Sms\ZhuTong\Client($USERNAME, $PASSWORD, $TEMPLATE);
$ret    = $client->useTemplate('验证码')->singleSend(13971777435, ['asdad']);

var_dump($ret);
