four-li开发辅助工具包
___

![](https://img.shields.io/badge/four_li'_tools-v.1.0-brightgreen.svg?style=social&logo=appveyor)
![](https://img.shields.io/badge/php-7.3-orange.svg)

## 安装
```bash
composer require four-li/tools
```

## 支持

- [x] [短信类](/src/Document/sms.md) 
- [x] [Excel类](/src/Document/excel.md)
- [x] [函数类](/src/Document/utils.md)
- [x] [apiSDK](/src/Document/sdk.md)
- [x] [支付类](/src/Document/pay.md)
- [x] [IP解析类](/src/Document/ip.md) 

- [ ] 自定义助手函数(详情查看`sql/helpers.php`) 

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
