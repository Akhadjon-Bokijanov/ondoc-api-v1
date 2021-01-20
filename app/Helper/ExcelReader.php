<?php

namespace App\Helper;

use \PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use \PhpOffice\PhpSpreadsheet\Reader\Xls;

class ExcelReader {

    public static function ReadAllExcelRows($file_path, $file_type="Xslx", $sheet_index=0){

        $reader = $file_type ==="Xslx" ? new Xlsx() : new Xls();
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($file_path);
        $sheet = $spreadsheet->getSheet($sheet_index);

        $data=[];
        $row_iterator = $sheet->getRowIterator();

        foreach ($row_iterator as $row){
            $row_data = [];

            $cell_iterator = $row->getCellIterator();
            foreach ($cell_iterator as $cell)
                $row_data[] = $cell->getCalculatedValue();
            $data[] = $row_data;
        }
        return $data;
    }

}
