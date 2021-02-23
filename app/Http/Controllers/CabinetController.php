<?php

namespace App\Http\Controllers;

use App\Models\Act;
use App\Models\CarrierWayBill;
use App\Models\Contract;
use App\Models\ContractPartner;
use App\Models\Empowerment;
use App\Models\Factura;
use App\Models\Notification;
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
        $user = $this->user();
        $awaiting_factura = Factura::where("buyerTin", $user["tin"])
            ->where("status", self::DOC_STATUS_WAIT)->count();
        $awaiting_contract=DB::table('contract_partners')
            ->join('contracts', 'contracts.contractId','=', 'contract_partners.contract_id')
            ->where('contract_partners.tin', $user["tin"])
            ->where('contracts.status', self::DOC_STATUS_WAIT)
            ->count();
        $awaiting_act = Act::where("buyerTin", $user["tin"])
            ->where("status", self::DOC_STATUS_WAIT)->count();
        $awaiting_emp = Empowerment::where("buyerTin", $user["tin"])
            ->where("status", self::DOC_STATUS_WAIT)->count();
        $awaiting_tty = CarrierWayBill::where("buyerTin", $user["tin"])
            ->where("status", self::DOC_STATUS_WAIT)->count();

        $n = Notification::where("isActive", true)
            ->whereNotIn("id",
                DB::table('user_read_notifications')
                    ->where("user_tin", $user["tin"])
                    ->pluck("notification_id")
                    ->toArray()
            )->orderBy("updated_at", "DESC")
            ->get();

        foreach ($n as $el){
            DB::table("user_read_notifications")
                ->insert(["user_tin"=>$user["tin"], "notification_id"=>$el->id]);
        }

        return [
            "notifications"=>$n,
            "factura_awaiting"=>$awaiting_factura,
            "contract_awaiting"=>$awaiting_contract,
            "act_awaiting"=>$awaiting_act,
            "emp_awating"=>$awaiting_emp,
            "tty_awaiting"=>$awaiting_tty,
            "income"=>$this->unionQueries(0)->count(),
            "outcome"=>$this->unionQueries(1)->count(),
            "rejected"=>$this->unionQueries(2)->count(),
            "saved"=>$this->unionQueries(3)->count(),
        ];
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
    const REJECTED_DOCS = 2;
    const SAVED_DOCS = 3;

    public function show($tab_index)
    {

        return $this->search_paginate($this->unionQueries($tab_index));
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


    private function unionQueries($tab_index){
        $facturas = DB::table('facturas')
            ->where(function ($q){
                $user = $this->user();
                $q->where('sellerTin', $user["tin"])
                    ->orWhere([["buyerTin", $user["tin"]]], ["state", "!=", 1] );
            })->select(['facturaNo as docNo', "sellerName", "sellerTin", "buyerTin", "buyerName", "created_at", "contractNo", DB::raw("'factura' as \"docType\""), "status", "id"]);

        $acts = DB::table('acts')
            ->where(function ($q){
                $user = $this->user();
                $q->where('sellerTin', $user["tin"])
                    ->orWhere([["buyerTin", $user["tin"]]], ["state", "!=", 1] );
            })->select(['actNo as docNo', "sellerName", "sellerTin", "buyerTin", "buyerName", "created_at", "contractNo", DB::raw("'act' as \"docType\""), "status", "id"]);

        $empowerments = DB::table('empowerments')
            ->where(function ($q){
                $user = $this->user();
                $q->where('sellerTin', $user["tin"])
                    ->orWhere([["buyerTin", $user["tin"]]], ["state", "!=", 1] );
            })->select(['empowermentNo as docNo', "sellerName", "sellerTin", "buyerTin", "buyerName", "created_at", "contractNo", DB::raw("'empowerment' as \"docType\""), "status", "id"]);


        $contracts = DB::table('contracts')
            ->where(function ($q){
                $user = $this->user();
                $q->where('sellerTin', $user["tin"]);
                //->orWhere([["buyerTin", $user["tin"]]], ["state", "!=", 1] );
            })->select(['contractNo as docNo', "sellerName", "sellerTin", DB::raw("(SELECT GROUP_CONCAT(tin) from contract_partners where contract_id=contractId) as \"buyerTin\""), DB::raw("(SELECT GROUP_CONCAT(name) from contract_partners where contract_id=contractId) as \"buyerName\""), "created_at", "contractNo",DB::raw("'contract' as \"docType\""), "status", "id"]);

        $ttys = DB::table('carrier_way_bills')
            ->where(function ($q){
                $user = $this->user();
                $q->where('sellerTin', $user["tin"])
                    ->orWhere([["buyerTin", $user["tin"]]], ["state", "!=", 1] );
            })->select(['contractNo as docNo', "sellerName", "sellerTin", "buyerTin", "buyerName", "created_at", "contractNo",DB::raw("'tty' as \"docType\""), "status", "id"]);

        return $this->tabQuery($facturas, $tab_index)
            ->union($this->tabQuery($ttys, $tab_index))
            ->union($this->tabQuery($acts, $tab_index))
            ->union($this->tabQuery($contracts, $tab_index))
            ->union($this->tabQuery($empowerments, $tab_index))
            ->orderBy("created_at", "DESC");
    }


    private function tabQuery($query, $tab){
        switch ($tab){
            case 0:
            default: return $query->whereIn("status", [self::DOC_STATUS_WAIT, self::DOC_STATUS_ACCEPTED]);
            case 1: return $query->whereIn("status", [self::DOC_STATUS_SEND, self::DOC_STATUS_SEND_ACCEPTED]);
            case 2: return $query->whereIn("status", [self::DOC_STATUS_REJECTED, self::DOC_STATUS_CANCELLED]);
            case 3: return  $query->whereIn("status", [self::DOC_STATUS_SAVED]);
        }
    }
}
