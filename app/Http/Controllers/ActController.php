<?php

namespace App\Http\Controllers;

use App\Helper\RoumingHelper;
use App\Models\Act;
use App\Models\ActProduct;
use App\Models\Factura;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ActController extends Controller
{
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

        switch ($tab){
            case "all": return $this->search_paginate(Act::where(function ($q){
                $user=$this->user();
                $q->where('sellerTin',$user->tin)
                    ->orWhere('buyerTin', $user->tin);
            }));

            case "out": return $this->search_paginate(Act::where("sellerTin", $this->user()->tin)
                ->whereNotIn("status", [self::DOC_STATUS_SAVED])
            );
            case "saved": return $this->search_paginate(Act::where("sellerTin", $this->user()->tin)
                ->where("status", self::DOC_STATUS_SAVED)
            );
            case "in":
            default: return $this->search_paginate(Act::where("buyerTin", $this->user()->tin)
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
        //

        $data = $request->all();
        try {

            $act = $data["act"];
            $products = $data["products"];

            $act["contractDate"] = date('Y-m-d 00:00:00', strtotime($act["contractDate"]));
            $act["actDate"] = date('Y-m-d 00:00:00', strtotime($act["actDate"]));

            $act["actId"] = Str::random(24);//RoumingHelper::getDocID();
            DB::beginTransaction();

            try {
                Act::create($act);

                $this->saveActProducts($products, $act["actId"]);

            }catch (\Exception $exception){
                DB::rollBack();
                return $exception->getMessage();
            }

            DB::commit();
            return ["message"=>"success", "ok"=>true];

        }catch (\Exception $exception){
            return $exception->getMessage();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Act  $act
     * @return \Illuminate\Http\Response
     */
    public function show($act)
    {
        //
        return Act::with(array('actProducts', 'actProducts.measure'))->find($act);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Act  $act
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $a)
    {
        //
        try {
            $data = $request->all();
            $act = $data["act"];

            $act["contractDate"] = date('Y-m-d 00:00:00', strtotime($act["contractDate"]));
            $act["actDate"] = date('Y-m-d 00:00:00', strtotime($act["actDate"]));

            DB::beginTransaction();
            try {
                $a = Act::find($a);
                $a->update($act);

                $this->saveActProducts($data["products"], $act["actId"]);

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
     * @param  \App\Models\Act  $act
     * @return \Illuminate\Http\Response
     */
    public function destroy(Act $act)
    {
        //
        $act->delete();
    }

    private function saveActProducts($products, $actId){

        ActProduct::where('actId', $actId)->delete();

        array_shift($products);

        foreach ($products as $product){
            $ap = new ActProduct();
            $ap->actId = $actId;
            $ap->ordNo = $product[Act::ORD_NO]["value"];
            $ap->measureId = $product[Act::MEASURE_ID]["value"];
            $ap->count = $product[Act::COUNT]["value"];
            $ap->price = $product[Act::PRICE]["value"];
            $ap->name = $product[Act::NAME]["value"];
            if (!$ap->save()){
                throw new \Exception("Act failed to save");
            }
        }
    }

    public function generatePdf($id){

        $data = Act::with(array('actProducts', 'actProducts.measure'))->find($id);
        if (empty($data)){
            return view('welcome');
        }
        //return view('pdf.act_template', ['data'=>$data]);

        $pdf = PDF::loadView('pdf.act_template', ["data"=>$data])
            ->setPaper('a4', 'landscape')
            ->setOptions([
                'isPhpEnabled'=>true,
                "isHtml5ParserEnabled"=>true,
                "isRemoteEnabled"=>true
            ]);

        $pdf->setOptions(['isPhpEnabled'=>true]);
        return $pdf->stream('act-'.$data->facturaId.'.pdf');
    }

}
