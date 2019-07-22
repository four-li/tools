<?php
/**                                                             ";
 * date: 2019/7/23
 * author: four-li
 */

namespace FourLi\Tools\Office;


class ColumnsReadFilter implements \PhpOffice\PhpSpreadsheet\Reader\IReadFilter
{
    # 实际场景中 常用到只读某些列 自定义过滤中暂只限制读取列
    private $limitCol;

    public function __construct($limitCol = [])
    {
        $this->limitCol = $limitCol;
    }

    public function readCell($column, $row, $worksheetName = '')
    {
        if (!$this->limitCol) return true;

        # 只读特定的列
        if (in_array($column, $this->limitCol)) {

            return true;
        }

        return false;
    }
}
