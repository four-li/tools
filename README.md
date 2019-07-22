four-li开发辅助工具包
___

![](https://img.shields.io/badge/four_li_tools-v.1.0-brightgreen.svg)

## 安装
```bash
composer require four-li/tools
```

## 使用

```php
include_once __DIR__ . '/vendor/autoload.php';

// 根据需求 使用工具 如腾讯云短信
$client = new \FourLi\Tools\Sms\Tencent\Client(
    'appid',
    'appKey',
    '签名'
);

$client->singleSend('手机号', ['模板中需要的参数1','模板中需要的参数2' ], '模板id1');
``` 

## 支持

- [x] [短信类](/src/Document/sms.md) 
- [x] [Excel类](/src/Document/)
