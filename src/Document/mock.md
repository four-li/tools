一些常用的简单数据模拟
===

#### 使用

```php
$client = new \FourLi\Tools\Mock\CnDataMock();

$userInfo['name'] = $client->getName();
``` 

#### 支持

方法 | 参数 |  解释 
-|-|-
getName | 无 | 生成姓名 |
getText | 无 | 生成一句话 |
getMobile | 无 | 生成一个随机手机号 |
getEmail | 无 | 生成一个随机邮箱号 |
getNodeNo | length:长度 | 生成一个指定长度的乱码 |
getRandomStr| len 生成长度 case 是否含大写字母 num 是否含数字 special 是否含符号   | 生成随机en字符 |
> 详情查看src/Example/mock.php
