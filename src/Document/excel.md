Excle类
---

## 表格读取

#### 支持

- [x] toArray() 自动读取表格类型 将excel数组转为数组
- [x] readFilter() 传递第二个参数过滤读取列
- [x] setIsFilterNullRow() 是否将读取的结果 过滤空行 默认ture过滤

#### 使用

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

