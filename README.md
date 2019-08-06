开发辅助工具包
___

![](https://img.shields.io/badge/four_li'_tools-v.1.0-brightgreen.svg?style=social&logo=appveyor)
![](https://img.shields.io/badge/php-7.3-orange.svg)

## 安装
```bash
composer require four-li/tools
```

## 支持

- [x] [短信](/src/Document/sms.md) 
- [x] [二维码](/src/Document/qrcode.md)
- [x] [Excel](/src/Document/excel.md)
- [x] [apiSDK](/src/Document/sdk.md)
- [x] [支付](/src/Document/pay.md)
- [x] [IP解析](/src/Document/ip.md) 
- [x] [更多工具](/src/Document/utils.md)

- [ ] 自定义助手函数(详情查看`spl/helpers.php`) 

## 使用

```php
include_once __DIR__ . '/vendor/autoload.php';

// 根据需求 使用工具 如腾讯云短信
$client = new \FourLi\Tools\Sms\Tencent\Client('appid','appKey','签名');
$client->singleSend('手机号', ['模板中需要的参数1','模板中需要的参数2' ], '模板id1');

// 使用PHP二维码库
$client = new FourLi\Tools\QrCode\PhpQrcode();
# 生成二维码
$client->setLogo(__DIR__ . '/../Qrcode/logo.jpg', 100, 100)# 设置logo
//->setSize(300)# 设置生成二维码的大小 px
//->setMargin(10) # 设置二维码的边距 px
//->setBackgroudColor('red')# 设置背景色 （二维码后面的背景色 一般为白色）
//->setForegroundColor('yellow') # 设置前景色（二维码的颜色 一般为黑色）
;

# 要保存二维码图片的路径
$savePath = __DIR__ . '/../QrCode/test.png';
$client->generator('https://github.com/four-li/tools', $savePath)//->download('下载二维码名字.png') # 直接浏览器下载
;

# 解析二维码
$img    = __DIR__ . '/../Qrcode/test.png';
$client = new FourLi\Tools\QrCode\PhpQrcode();
$text   = $client->reader($img);
var_dump($text);

// 如解析ip地址
$client = new FourLi\Tools\Ip\Resolver();
$ret = $client->resolveIpToRegions('60.1.2.1');
var_dump($ret);
``` 

> 更多详细信息请参阅支持
