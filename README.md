four-li开发辅助工具包
___


## 短信类

- [x] 腾讯短信

查看appid， appkey， 申请模板 签名
短信运营商平台登录地址： [腾讯云](https://console.cloud.tencent.com/sms)

_使用_

```php
$client = new \FourLi\Tools\Sms\Tencent\Client(
    'appid',
    'appKey',
    '签名'
);

$client->singleSend('手机号', ['模板中需要的参数1','模板中需要的参数2' ], '模板id1');
``` 

> 详情查看src/Example/sms.php


- [x] 容联云通讯

短信运营商平台登录地址： [容联](https://www.yuntongxun.com/)

需要准备参数

- accountsid： 主账号，登陆云通讯网站后，可在控制台首页看到开发者主账号ACCOUNT SID
- accountToken：同上 
- appId：  创建应用
- 模板： 创建模板 * 改短信平台不需要创建签名，签名固定嵌套在模板内

```php
$client = new \FourLi\Tools\Sms\RongLian\Client($accountSid, $accountToken, $appId, $templates);

$ret = $client->useTemplate('验证码')->singleSend(13971777435, ['verifyCode']);
```

详情demo查看src/Example/sms.php

> 容联的添加客qq好友催他可以快速审核 😁

- [x] 阿里大于

需要accessKeyId， accessKeySecret，申请模板 签名
短信运营商平台登录地址： [阿里云](https://dysms.console.aliyun.com/dysms.htm?#/overview)

```php
# 阿里大于
$key_id     = '';
$key_secret = '';
$smsSign    = '';
$templates  = [
    '验证码' => 'SMS_151576882'
];
$client = new \FourLi\Tools\Sms\ALiYun\Client($key_id, $key_secret, $smsSign, $templates);
$customParam = ["code" => '123456'];
$ret = $client->useTemplate('SMS_151576882')->singleSend(13971777435, $customParam);

```

> 需要注意的是 阿里云的短信模板参数 是键值对

- [x] 助通科技

获取username， password，申请模板
短信运营商平台登录地址： [联系客服](http://www.ztinfo.cn/page/download)

> 吐槽一下， 改短信平台申请模板是需要找客服的， 没有界面可以自己申请

```php
$USERNAME = '';
$PASSWORD = '';
$TEMPLATE = ['验证码' => '【xx公司】您的验证码为：'];

$client = new \FourLi\Tools\Sms\ZhuTong\Client($USERNAME, $PASSWORD, $TEMPLATE);
$ret = $client->useTemplate('验证码')->singleSend(13971777435, ['123456']);
```


