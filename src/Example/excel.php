<?php

include_once __DIR__ . '/../../vendor/autoload.php';

//use PhpOffice\PhpSpreadsheet\Spreadsheet;
//use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
//
//$spreadsheet = new Spreadsheet();
//$sheet       = $spreadsheet->getActiveSheet();
//$sheet->setCellValue('A1', 'Hello World !');
//
//$writer = new Xlsx($spreadsheet);
//$writer->save('hello world.xlsx');

$office = new \FourLi\Tools\Office\Excel();

$file = __DIR__ . '/demo.xlsx';

$office->reader($file);


