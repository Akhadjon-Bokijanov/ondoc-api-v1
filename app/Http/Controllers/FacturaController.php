<?php

namespace App\Http\Controllers;

use App\Models\Factura;
//use Barryvdh\DomPDF\PDF;
use App\Models\FacturaProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Str;

class FacturaController extends Controller
{

    //FACTURA CURRENT STATES
    const STATE_SAVED = 1;




    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //$facturas = auth()->user()->facturas;
        $facturas = Factura::all();
        return $facturas;
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //create factura

        $data = $request->all();
        //if ()
        $factura = $data["factura"];
        $factura["facturaId"] =Str::random(40);
        $factura["facturaProductId"] =Str::random(40);
        //$factura["facturaDate"] = date('Y-m-d 00:00:00', strtotime($factura["facturaDate"]));
        //$factura["contractDate"] = date('Y-m-d 00:00:00', strtotime($factura["contractDate"]));
        //$factura["empowermentDateOfIssue"] = date('Y-m-d 00:00:00', strtotime($factura["empowermentDateOfIssue"]));

        $products = $data["products"];
        array_shift($products);
        foreach ($products as $product){
            if($product){
                $fProduct = new FacturaProduct();
                $fProduct->facturaProductId = $factura["facturaProductId"];
                $fProduct->ordNo = $product[FacturaProduct::ORD_NO]["value"];
                $fProduct->name = $product[FacturaProduct::PRODUCT_NAME]["value"];
                $fProduct->catalogCode = $product[FacturaProduct::CATALOGE_CODE]["value"];
                $fProduct->catalogName = "TO BE INSERTED!";
                $fProduct->barCode = $product[FacturaProduct::BAR_CODE]["value"];
                $fProduct->measureId = $product[FacturaProduct::MEASURE]["value"];
                $fProduct->count = $product[FacturaProduct::AMOUNT]["value"];
                $fProduct->baseSumma = $product[FacturaProduct::PRICE]["value"];
                $fProduct->exciseRate = $product[FacturaProduct::EXCISE_RATE]["value"];
                $fProduct->exciseSum = $product[FacturaProduct::EXCISE_AMOUNT]["value"];
                $fProduct->deliverySum = $product[FacturaProduct::DELIVERY_PRICE]["value"];
                $fProduct->vatRate = $product[FacturaProduct::VAT_RATE]["value"];
                $fProduct->deliverySumWithVat = $product[FacturaProduct::PRICE]["value"] + $product[FacturaProduct::VAT_RATE]["value"];
                $fProduct->summa = $product[FacturaProduct::DELIVERY_SUM_WITH_VAT_EXCISE]["value"];
                $fProduct->withoutVat = $product[FacturaProduct::VAT_RATE]["value"] ? true : false;
                $fProduct->save();
            }
        }
        return $products;
        //foreach ()

        return Factura::create($factura);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($factura)
    {
        //
        $data = Factura::with(array('facturaProducts', 'facturaProducts.measure'))->find($factura);
        return $data;

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Factura $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Factura $factura)
    {
        //delete factura and factura products
        FacturaProduct::destroy(['facturaProductId'=>$factura->facturaProductid]);
        return $factura->delete();
    }


    //Generating Factura PDF file
    public function generatePdf($id){

        $data = Factura::with(array('facturaProducts', 'facturaProducts.measure'))->find($id);
        //return view('pdf.factura_template', ['data'=>$data]);

        $pdf = PDF::loadView('pdf.factura_template', ["data"=>$data])
            ->setPaper('a4', 'landscape')
            ->setOptions([
                'isPhpEnabled'=>true,
                "isHtml5ParserEnabled"=>true,
                "isRemoteEnabled"=>true
                ]);

        $pdf->setOptions(['isPhpEnabled'=>true]);

        return $pdf->stream('factura-'.$data->facturaId.'.pdf');
    }

}
