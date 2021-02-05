<?php

namespace App\Http\Controllers;

use App\Models\CarrierWayBill;
use Illuminate\Http\Request;
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
            $tty["contractDate"] = date('Y-m-d 00:00:00', strtotime($tty["contractDate"]));
            $tty["tripTicketDate"] = date('Y-m-d 00:00:00', strtotime($tty["tripTicketDate"]));
            $tty["wayBillDate"] = date('Y-m-d 00:00:00', strtotime($tty["wayBillDate"]));
            $tty["wayBillId"] = Str::random(24);
            $tty["wayBillProductId"] = Str::random(24);
            CarrierWayBill::create($tty);

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
        return CarrierWayBill::find($carrierWayBill);
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
            $tty["contractDate"] = date('Y-m-d 00:00:00', strtotime($tty["contractDate"]));
            $tty["tripTicketDate"] = date('Y-m-d 00:00:00', strtotime($tty["tripTicketDate"]));
            $tty["wayBillDate"] = date('Y-m-d 00:00:00', strtotime($tty["wayBillDate"]));

            $t->update($tty);
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
}