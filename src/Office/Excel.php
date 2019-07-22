<?php
/**                                                             ";
 * date: 2019/7/22
 * author: four-li
 */

namespace FourLi\Tools\Office;


use PhpOffice\PhpSpreadsheet\IOFactory;

class Excel
{
    /**
     * - i.e.  将excel转数组
     * - e.g.
     */
    public function reader($file)
    {
        $spreadsheet = IOFactory::load($file);
        try {
            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true) ?: [];
            return $sheetData;
        } catch (\Exception $e) {
//            $e->getMessage();
            return [];
        }
    }

    public function generaterNormalExcel()
    {
        //
    }
}
