辅助工具函数类
___

## 支持

- [x] 字符串处理
- [x] 数组处理

## 使用

#### 字符串处理

```php
$utils = new \FourLi\Tools\Utils\StrHandler();

// 获取中文字符串中首个字符的首拼
$ret = $utils->getFirstChar('李四哥'); # L

// 获取中文字符串每个中文字符的首拼
$ret = $utils->getAllFristChar('李四哥'); # LSG

var_dump($ret);
``` 

> 详情查看src/Example/utils.php
