二维码解析、生成
---

> 支持两种方式  
1 使用php类库（推荐） 
2 使用三方api（需付费且不稳定）

## 使用php库 （推荐）

### 生成二维码

```php
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
```

### 解析二维码

```php
# 解析二维码
$img = __DIR__ . '/../Qrcode/logo.jpg';
$client = new FourLi\Tools\QrCode\PhpQrcode();
$text = $client->reader($img);
var_dump($text);```
```

方法 | 参数 |  解释 
-|-|-
reader | `$img`: 需要解析的图片路径 | 解析二维码图片的内容 返回字符串 或 false为解析失败 |
generator | `$text`:二维码的内容 `$path`: 保存的路径 | 生成二维码 更多set支持 |

---

## 调用api 

该二维码调用阿里云付费接口

```php

```

