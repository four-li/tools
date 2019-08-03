<?php

include_once __DIR__ . '/../../vendor/autoload.php';

# 使用PHP二维码库
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
$client->generator('https://github.com/four-li/tools', $savePath);

# 解析二维码
$text = $client->reader($savePath);
var_dump($text);
