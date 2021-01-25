<?php

namespace App\Http\Controllers;

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
        $query = "
            SELECT facturas.facturaNo as docNo, buyerTin, buyerName, created_at, contractNo, 'factura' as docType, status FROM facturas WHERE buyerTin = ?
            UNION
            SELECT acts.actNo as docNo, created_at, buyerName, buyerTin, contractNo, 'act' as docType, status FROM acts WHERE buyerTin = ?
            UNION
            SELECT empowerments.empowermentNo as docNo, created_at, buyerName, buyerTin, contractNo, 'empowerment' as docType, status FROM empowerments WHERE buyerTin = ?
            UNION
            SELECT contracts.contractNo as docNo, created_at, buyerName, buyerTin, contractNo, 'contract' as docType, status FROM contracts WHERE buyerTin = ? ";
        if ($tab_index == self::RECEIVED_DOCS){
            $docs = DB::select($query."
            ORDER BY created_at DESC

            LIMIT 200

        ", [$user->tin, $user->tin, $user->tin, $user->tin]);
        }


        return ["docs"=>$docs];

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
