<?php

namespace App\Http\Controllers;

use App\Models\FacturaProduct;
use App\Helper\ExcelReader;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Input;


class FacturaProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        Excel::load(Input::file('file'), function ($reader) {
            $data=[];

            $reader->each(function($sheet) {
                foreach ($sheet->toArray() as $row) {
                    $data[]=$row;
                }
            });
            return $data;
        });
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(FacturaProduct $facturaProduct)
    {
        //
        $facturaProduct->measure;
        return $facturaProduct;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function importExcel(Request $request)
  {
        $path = $request->file('file')->store('/uploads', 'public');
        $real_path = public_path("storage/{$path}");
        $rows = ExcelReader::ReadAllExcelRows($real_path);

        $res_data=[];
        $start_row_index = 3;
        $ord_no=1;
        foreach ($rows as $key=>$row){
            if($key >= $start_row_index){
                $new_row = [];
                foreach ($row as $cell){
                    $new_row[]=["value"=>$cell];
                }
                $res_data[]=$new_row;
            }
        }

        if (file_exists("storage/{$path}")){
            unlink("storage/{$path}");
        }

        return ["excel"=>$res_data];
    }
}
