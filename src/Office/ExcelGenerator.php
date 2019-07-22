<?php
/**                                                             ";
 * date: 2019/7/22
 * author: four-li
 */

namespace FourLi\Tools\Office;


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExcelGenerator
{
    private $singleSheet;

    # 支持生成的类型
    const EXCEL_TYPE_XLSX = 'xlsx';
    const EXCEL_TYPE_XLS  = 'xls';
    const EXCEL_TYPE_CSV  = 'csv';

    # 默认表格类型
    private $excelType = self::EXCEL_TYPE_XLSX;

    const COLOR_BLACK      = 'FF000000';
    const COLOR_WHITE      = 'FFFFFFFF';
    const COLOR_RED        = 'FFFF0000';
    const COLOR_DARKRED    = 'FF800000';
    const COLOR_BLUE       = 'FF0000FF';
    const COLOR_DARKBLUE   = 'FF000080';
    const COLOR_GREEN      = 'FF00FF00';
    const COLOR_DARKGREEN  = 'FF008000';
    const COLOR_YELLOW     = 'FFFFFF00';
    const COLOR_DARKYELLOW = 'FF808000';


    public function normal($title, $data, $fileName, $exportDir = '', $isDownload = false)
    {
        # ..

        $spreadsheet = new Spreadsheet();

//        $spreadsheet->setActiveSheetIndex(1);

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Hello World !');
        $sheet->setCellValue('A2', 'Hello World2 !');

        $writer = new Xlsx($spreadsheet);

        # 由于Office2003兼容包中存在错误，打开Xlsx电子表格时可能会出现一些小问题（主要与公式计算有关）。您可以使用以下代码启用Office2003兼容性
        # $writer->setOffice2003Compatibility(true);

        # 默认情况下，此编写器预先计算电子表格中的所有公式 这在大型电子表格上可能很慢，甚至可能不需要 禁用公式预先计算 设为false
        # $writer->setPreCalculateFormulas(false);

        # 通过编写BOM文件头，可以将CSV文件标记为UTF-8。可以使用以下代码启用此功能

        $writer->save('hello_world.xlsx');
    }
}
