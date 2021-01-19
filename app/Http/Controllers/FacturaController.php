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

    //FACTURA PRODUCT INDEXES IN TABLE
    const ORD_NO = 0;
    const PRODUCT_NAME = 1;
    const CATALOGE_CODE = 2;
    const BAR_CODE = 3;
    const MEASURE = 4;
    const AMOUNT = 5;
    const PRICE = 6;
    const EXCISE_RATE = 7;
    const EXCISE_AMOUNT = 8;
    const DELIVERY_PRICE = 9;
    const VAT_RATE= 10;
    const VAT_AMOUNT = 11;
    const DELIVERY_SUM_WITH_VAT_EXCISE = 12;


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
                $fProduct->ordNo = $product[self::ORD_NO]["value"];
                $fProduct->name = $product[self::PRODUCT_NAME]["value"];
                $fProduct->catalogCode = $product[self::CATALOGE_CODE]["value"];
                $fProduct->catalogName = "TO BE INSERTED!";
                $fProduct->barCode = $product[self::BAR_CODE]["value"];
                $fProduct->measureId = $product[self::MEASURE]["value"];
                $fProduct->count = $product[self::AMOUNT]["value"];
                $fProduct->baseSumma = $product[self::PRICE]["value"];
                $fProduct->exciseRate = $product[self::EXCISE_RATE]["value"];
                $fProduct->exciseSum = $product[self::EXCISE_AMOUNT]["value"];
                $fProduct->deliverySum = $product[self::DELIVERY_PRICE]["value"];
                $fProduct->vatRate = $product[self::VAT_RATE]["value"];
                $fProduct->deliverySumWithVat = $product[self::PRICE]["value"] + $product[self::VAT_RATE]["value"];
                $fProduct->summa = $product[self::DELIVERY_SUM_WITH_VAT_EXCISE]["value"];
                $fProduct->withoutVat = $product[self::VAT_RATE]["value"] ? true : false;
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
