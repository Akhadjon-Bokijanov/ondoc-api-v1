<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CabinetController extends Controller
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    const RECEIVED_DOCS = 0;
    const SENT_DOCS = 1;
    const REJECTED_DOCS = 3;
    const SAVED_DOCS = 4;

    public function show($tab_index)
    {
        //
        //return $tab_index;
        $user = $this->user();
        $docs = [];

        $facturas = DB::table('facturas')
            ->where(function ($q){
                $user = $this->user();
                $q->where('sellerTin', $user["tin"])
                    ->orWhere([["buyerTin", $user["tin"]]], ["state", "!=", 1] );
            })->select(['facturaNo as docNo', "sellerName", "sellerTin", "buyerTin", "buyerName", "created_at", "contractNo", DB::raw('"factura" as docType'), "status"]);

        $acts = DB::table('acts')
            ->where(function ($q){
                $user = $this->user();
                $q->where('sellerTin', $user["tin"])
                    ->orWhere([["buyerTin", $user["tin"]]], ["state", "!=", 1] );
            })->select(['actNo as docNo', "sellerName", "sellerTin", "buyerTin", "buyerName", "created_at", "contractNo", DB::raw("'act' as docType"), "status"]);

        $empowerments = DB::table('empowerments')
            ->where(function ($q){
                $user = $this->user();
                $q->where('sellerTin', $user["tin"])
                    ->orWhere([["buyerTin", $user["tin"]]], ["state", "!=", 1] );
            })->select(['empowermentNo as docNo', "sellerName", "sellerTin", "buyerTin", "buyerName", "created_at", "contractNo", DB::raw("'empowerment' as docType"), "status"]);

        $contracts = DB::table('contracts')
            ->where(function ($q){
                $user = $this->user();
                $q->where('sellerTin', $user["tin"])
                    ->orWhere([["buyerTin", $user["tin"]]], ["state", "!=", 1] );
            })->select(['contractNo as docNo', "sellerName", "sellerTin", "buyerTin", "buyerName", "created_at", "contractNo",DB::raw("'contract' as docType"), "status"]);

        $ttys = DB::table('carrier_way_bills')
            ->where(function ($q){
                $user = $this->user();
                $q->where('sellerTin', $user["tin"])
                    ->orWhere([["buyerTin", $user["tin"]]], ["state", "!=", 1] );
            })->select(['contractNo as docNo', "sellerName", "sellerTin", "buyerTin", "buyerName", "created_at", "contractNo",DB::raw("'tty' as docType"), "status"]);

        $all = $facturas->union($ttys)
            ->union($acts)
            ->union($contracts)
            ->union($contracts)
            ->orderBy("created_at", "DESC")->get();


        return ["docs"=>$all];

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
