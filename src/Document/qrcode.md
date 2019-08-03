二维码解析、生成
---

> 支持两种方式  
1 使用php类库（推荐） 
2 使用三方api（需付费且不稳定）

# 使用php库 （推荐）

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

> 不支持解析小程序码

```php
$img = __DIR__ . '/../Qrcode/logo.jpg';
$client = new FourLi\Tools\QrCode\PhpQrcode();
$text = $client->reader($img);
var_dump($text);
```

方法 | 参数 |  解释 
-|-|-
reader | `$img`: 需要解析的图片路径 | 解析二维码图片的内容 返回字符串 或 false为解析失败 |
generator | `$text`:二维码的内容 `$path`: 保存的路径 | 生成二维码 更多set支持 |

---


# 调用api 

以下为调用[阿里云彩色二维码生成与解码API](https://market.aliyun.com/products/57126001/cmapi021204.html?spm=5176.2020520132.101.1.6c587218rg6Fg0#sku=yuncode1520400000)  需付费

### 生成二维码

```php
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
```

### 解析二维码

> 不支持解析小程序码

```php
$appcode = ''; # 从接口提供商获取的appcode
$client  = new \FourLi\Tools\QrCode\ApiQrcode($appcode);

$imgPath = __DIR__ . '/../QrCode/test.png';
//$imgUrl = 'img.xx.com/a.jpg';

# 解析二维码 支持本地文件和在线图片url
$text = $client->reader($imgPath);
var_dump($text);
```

方法 | 参数 |  解释 
-|-|-
reader | `$img`: 需要解析的图片路径 或在线图片url | 解析二维码图片的内容 返回字符串 或 false为解析失败 |
generator | `$text`:二维码的内容 `$path`: 保存的路径 | 生成二维码 更多set支持 |


## 测试

```bash
php -S localhost:8100 src/Example/qrcode.php
```
