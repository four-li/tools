IP解析类
___

将ip解析对应省市区

#### 使用

```php
$ipService = new FourLi\Tools\Ip\Resolver();

$ret = $ipService->resolveIpToRegions('60.1.2.1');

var_dump($ret);
``` 

> 详情查看src/Example/ip.php
