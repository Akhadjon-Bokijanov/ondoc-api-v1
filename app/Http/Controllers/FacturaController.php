<?php

namespace App\Http\Controllers;

use App\Helper\RoumingHelper;
use App\Models\Factura;
//use Barryvdh\DomPDF\PDF;
use App\Models\FacturaProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
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

        $tab="in";
        if (isset($_GET["tab"])){
            $tab=$_GET["tab"];
        }
        $pagination_limit = isset($_GET["limit"]) ? $_GET["limit"] : 10;
        switch ($tab){
            case "all": return $this->search_paginate(Factura::
            where(function ($q){
                $user=$this->user();
                $q->where('sellerTin',$user->tin)
                    ->orWhere('buyerTin', $user->tin);
            })
            );

            case "out": return $this->search_paginate(Factura::
            whereNotIn("status", [self::DOC_STATUS_SAVED, self::DOC_STATUS_WAIT])
            //->where("sellerTin", $this->user()->tin)
                );
            case "saved": return $this->search_paginate(Factura::
                where("status", self::DOC_STATUS_SAVED)
                //->where("sellerTin", $this->user()->tin)
            );
            case "in":
            default: return $this->search_paginate(Factura::where('status', self::DOC_STATUS_WAIT)
            //where("buyerTin", $this->user()->tin)
        );

        }

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

        try {
            $data = $request->all();
            //if ()
            $factura = $data["factura"];
            $factura["facturaId"] = Str::random(24); //RoumingHelper::getDocID();
            $factura["facturaProductId"] = Str::random(24);//RoumingHelper::getDocID();
            $factura["facturaDate"] = date('Y-m-d 00:00:00', strtotime($factura["facturaDate"]));
            $factura["contractDate"] = date('Y-m-d 00:00:00', strtotime($factura["contractDate"]));
            $factura["empowermentDateOfIssue"] = date('Y-m-d 00:00:00', strtotime($factura["empowermentDateOfIssue"]));

            DB::beginTransaction();
            Factura::create($factura);

            $products = $data["products"];

            $this->saveProductFacturas($products, $factura["facturaProductId"]);
            DB::commit();
            return ["message"=>"success", "ok"=>true];
        } catch (\Exception $exception){
            return $exception->getMessage();
        }

    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($factura)
    {
        //
        return Factura::with(array('facturaProducts', 'facturaProducts.measure'))->find($factura);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $fac = Factura::find($id);

            $data = $request->all();
            $factura = $data["factura"];
            $factura["facturaDate"] = date('Y-m-d 00:00:00', strtotime($factura["facturaDate"]));
            $factura["contractDate"] = date('Y-m-d 00:00:00', strtotime($factura["contractDate"]));
            $factura["empowermentDateOfIssue"] = date('Y-m-d 00:00:00', strtotime($factura["empowermentDateOfIssue"]));

            $fac->update($factura);
        } catch (\Exception $exception){
            DB::rollBack();
            return $exception->getMessage();
        }

        try {
            $this->saveProductFacturas($data["products"], $factura["facturaProductId"]);
        } catch (\Exception $exception){
            DB::rollBack();
            return $exception->getMessage();
        }
        DB::commit();

        return ["message"=>"success", "ok"=>true];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Factura $factura)
    {
        return $factura->delete();
    }



    public function saveProductFacturas($products, $facturaProductId, $deleteOldItems=true){

        if ($deleteOldItems){
            DB::table('factura_products')->where('facturaProductId', $facturaProductId)->delete();
        }

        array_shift($products);
        foreach ($products as $product){
            if($product){
                $fProduct = new FacturaProduct();
                $fProduct->facturaProductId = $facturaProductId;
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
    }

}
