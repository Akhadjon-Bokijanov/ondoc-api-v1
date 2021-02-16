<?php

namespace App\Http\Controllers;

use App\Helper\RoumingHelper;
use App\Models\CarrierWayBill;
use App\Models\WaybillingItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CarrierWayBillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        return CarrierWayBill::where(function ($q){
            $user = $this->user();
            $q->where("sellerTin", $user["tin"])
                ->orWhere("buyerTin", $user["tin"]);
        })->get();
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
        try {
            $data = $request->all();

            $tty = $data["tty"];

            $products = $data["products"];

            $tty["contractDate"] = date('Y-m-d 00:00:00', strtotime($tty["contractDate"]));
            $tty["tripTicketDate"] = date('Y-m-d 00:00:00', strtotime($tty["tripTicketDate"]));
            $tty["wayBillDate"] = date('Y-m-d 00:00:00', strtotime($tty["wayBillDate"]));
            $tty["wayBillId"] = Str::random(24); //RoumingHelper::getDocID();
            $tty["wayBillProductId"] = Str::random(24); //RoumingHelper::getDocID();

            try {
                DB::beginTransaction();

                $this->saveProducts($products, $tty["wayBillProductId"]);

                CarrierWayBill::create($tty);
            }catch (\Exception $exception){
                DB::rollBack();
                return $exception->getMessage();
            }
            DB::commit();

            return ["message"=>"success", "ok"=>true];

        } catch (\Exception $exception){
            return $exception->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CarrierWayBill  $carrierWayBill
     * @return \Illuminate\Http\Response
     */
    public function show($carrierWayBill)
    {
        //
        return CarrierWayBill::with("products", "products.measure")->find($carrierWayBill);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CarrierWayBill  $carrierWayBill
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $carrierWayBill)
    {
        //
        try {
            $t = CarrierWayBill::find($carrierWayBill);

            $data = $request->all();

            $tty = $data["tty"];

            $products = $data["products"];

            $tty["contractDate"] = date('Y-m-d 00:00:00', strtotime($tty["contractDate"]));
            $tty["tripTicketDate"] = date('Y-m-d 00:00:00', strtotime($tty["tripTicketDate"]));
            $tty["wayBillDate"] = date('Y-m-d 00:00:00', strtotime($tty["wayBillDate"]));

            DB::beginTransaction();
            try {
                $this->saveProducts($products, $t["wayBillProductId"]);

                $t->update($tty);
            }catch (\Exception $exception){
                DB::rollBack();
                return $exception->getMessage();
            }
            DB::commit();

            return ["message"=>"success", "ok"=>true];
        } catch (\Exception $exception){
            return $exception->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CarrierWayBill  $carrierWayBill
     * @return \Illuminate\Http\Response
     */
    public function destroy($carrierWayBill)
    {
        //
        return CarrierWayBill::destroy($carrierWayBill);

    }

    public function saveProducts($products, $billProductId, $deleteOldItems=true){

        if ($deleteOldItems){
            DB::table('waybilling_items')->where("waybilling_id", $billProductId)->delete();
        }

        try {
            array_shift($products);
            foreach ($products as $product){
                if($product){
                    $fProduct = new WaybillingItem();
                    $fProduct->waybilling_id = $billProductId;
                    $fProduct->name = $product[WaybillingItem::NAME]["value"];
                    $fProduct->docs = $product[WaybillingItem::DELIVERY_DOCS]["value"];
                    $fProduct->deliveryCost = $product[WaybillingItem::DELIVERY_PRICE]["value"];
                    $fProduct->measureId = $product[WaybillingItem::MEASEURE_ID]["value"];
                    $fProduct->price = $product[WaybillingItem::PRICE]["value"];
                    $fProduct->count = $product[WaybillingItem::COUNT]["value"];
                    $fProduct->weightMeasureMethod = $product[WaybillingItem::MEASURE_METHOD]["value"];
                    $fProduct->itemClass = $product[WaybillingItem::ITEM_CLASS]["value"];
                    $fProduct->weightBrut = $product[WaybillingItem::BRUTTO_WEIGHT]["value"];
                    $fProduct->weightNet = $product[WaybillingItem::NETTO_WEIGHT]["value"];

                    if (!$fProduct->save()){
                        throw new \Exception("Failed to insert WayBillingItem");
                    }
                }
            }

        } catch (\Exception $exception){
            return $exception;
        }
    }


}
