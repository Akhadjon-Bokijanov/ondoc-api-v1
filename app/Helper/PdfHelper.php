<?php


namespace App\Helper;


use App\Models\Act;
use App\Models\CarrierWayBill;
use App\Models\Company;
use App\Models\Contract;
use App\Models\Empowerment;
use App\Models\Factura;
use App\Models\User;
use Barryvdh\DomPDF\Facade as PDF;


class PdfHelper
{
    public function generatePdf($doc, $id, $auth_key, $tin){
        try {
            $user = Company::where(["tin"=>$tin])->select("auth_key")->first();

            if (empty($user)){
                $user = User::where(["tin"=>$tin])->select("auth_key")->first();
            }

            if (empty($user) && $user->auth_key !==$auth_key){
                return view("welcome");
            }

            $data=null;
            $view = "";

            switch ($doc){
                case "acts": {
                    $data = Act::with(array('actProducts', 'actProducts.measure'))->find($id);
                    $view = "pdf.act_template";
                }
                    break;
                case "empowerments": {
                    $data = Empowerment::with(array('products', 'products.measure'))->find($id);
                    $view = "pdf.empowerment_template";
                }
                    break;

                case "facturas": {
                    $view="pdf.factura_template";
                    $data = Factura::with(array('facturaProducts', 'facturaProducts.measure'))->find($id);
                }
                    break;
                case "contracts": {
                    $view = "pdf.contract_template";
                    $data = Contract::with(array('contractProducts', 'contractProducts.measure', 'contractParts'))->find($id);
                }
                    break;
                case "ttys": {
                    $view = "pdf.waybilling_template";
                    $data = CarrierWayBill::with('products', 'products.measure')->find($id);
                }
                    break;
            }


            if (empty($data)){
                return view('welcome');
            }
            //return view('pdf.waybilling_template', ['data'=>$data]);

            $pdf = PDF::loadView($view, ["data"=>$data])
                ->setPaper('a4', 'landscape')
                ->setOptions([
                    'isPhpEnabled'=>true,
                    "isHtml5ParserEnabled"=>true,
                    "isRemoteEnabled"=>true
                ]);

            $pdf->setOptions(['isPhpEnabled'=>true]);
            return $pdf->stream($tin.'-'.$doc.'-'.'ondocs_uz.pdf');
        } catch (\Exception $exception){
            return $exception->getMessage();
        }

    }

}
