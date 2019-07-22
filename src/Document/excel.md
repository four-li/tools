Excle类
---

## 表格读取

```php
$office = new \FourLi\Tools\Office\ExcelReader();
$file   = __DIR__ . '/demo.csv';

# 普通读取excel 不过滤空行
$excelArr = $office->setIsFilterNullRow(false)->toArray($file);
print_r($excelArr);
# 指定读取某几列
$excelArr = $office->readFilter($file, ['A']);
print_r($excelArr);
```


## 表格生成

