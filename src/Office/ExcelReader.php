<?php
/**                                                             ";
 * date: 2019/7/22
 * author: four-li
 */

namespace FourLi\Tools\Office;


use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ExcelReader
{
    private $isFilterNullRow = true;

    /**
     * - i.e. 是否将读取的数组 过滤掉空的行并重置数组索引 默认ture
     *
     * @param bool $isFilterNullRow
     * @return ExcelReader
     */
    public function setIsFilterNullRow(bool $isFilterNullRow = true): ExcelReader
    {
        $this->isFilterNullRow = $isFilterNullRow;
        return $this;
    }


    /**
     * - i.e.  将excel转数组
     * - e.g.
     */
    public function toArray(string $file): array
    {
        $spreadsheet = IOFactory::load($file);

        return $this->handlerData($spreadsheet);
    }

    /**
     * - i.e. 只读取表格特定的列
     * - e.g. $excel->readFilter('1.xlsx', ['A', 'C']);
     */
    public function readFilter(string $file, $limitColumns = [])
    {
        $inputFileType = ucfirst(pathinfo($file, PATHINFO_EXTENSION));
        $reader        = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        $reader->setReadFilter(new ColumnsReadFilter($limitColumns));
        $spreadsheet = $reader->load($file);

        return $this->handlerData($spreadsheet);
    }

    /**
     * - i.e. 处理表格中的数据 将空行删除
     * - e.g.
     *
     * @param Spreadsheet $spreadsheet
     * @return array
     */
    private function handlerData(Spreadsheet $spreadsheet)
    {
        try {
            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true) ?: [];

            if (!$sheetData) return [];
        } catch (\Exception $e) {
//            $e->getMessage();
            return [];
        }

        # 不过滤空行
        if (!$this->isFilterNullRow) return $sheetData;

        # 过滤空行并且重置数组索引
        $ret = [];
        foreach ($sheetData as $row) {
            # 行拼起来如果没有值
            if (!implode('', $row)) continue;

            $ret[] = $row;
        }

        return $ret;
    }
}
