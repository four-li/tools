<?php

include_once __DIR__ . '/../../vendor/autoload.php';

$office = new \FourLi\Tools\Office\ExcelReader();
$file   = __DIR__ . '/demo.csv';

# 普通读取excel 不过滤空行
$excelArr = $office->setIsFilterNullRow(false)->toArray($file);
//print_r($excelArr);
# 指定读取某几列
$excelArr = $office->readFilter($file, ['A']);
//print_r($excelArr);

//$generator = new \FourLi\Tools\Office\ExcelGenerator();
//
//$generator->normal(1,2,3,4);

//print_r($excelArr);

