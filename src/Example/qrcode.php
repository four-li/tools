<?php

include_once __DIR__ . '/../../vendor/autoload.php';

goto api;

die;

#####【 使用PHP二维码库 】######
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

#####【 使用三方api 】######

api:

$appcode = ''; # 从接口提供商获取的appcode
$client  = new \FourLi\Tools\QrCode\ApiQrcode($appcode);

$imgPath = __DIR__ . '/../QrCode/test.png';
//$imgUrl = 'img.xx.com/a.jpg';

$client
    ->setSize(500)
    ->setForegroundColor('#888888')
    ->setBackgroudColor('#EEEEEE');

# 生成二维码
$client->generator('李四哥', $imgPath)->download('李四哥.png')
;

# 解析二维码 支持本地文件和在线图片url
$text = $client->reader($imgPath);

var_dump($text);


