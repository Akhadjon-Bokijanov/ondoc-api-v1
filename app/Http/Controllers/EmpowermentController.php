<?php

namespace App\Http\Controllers;

use App\Models\Empowerment;
use App\Models\EmpowermentProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EmpowermentController extends Controller
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
            case "all": return Empowerment::where(function ($q){
                $user=$this->user();
                $q->where('sellerTin',$user->tin)
                    ->orWhere('buyerTin', $user->tin);
            })->get();

            case "out": return Empowerment::where("sellerTin", $this->user()->tin)
                ->whereNotIn("status", [self::DOC_STATUS_SAVED])
                ->get();
            case "saved": return Empowerment::where("sellerTin", $this->user()->tin)
                ->where("status", self::DOC_STATUS_SAVED)
                ->get();
            case "in":
            default: return Empowerment::where("buyerTin", $this->user()->tin)
                ->get();
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
        try {

            $data = $request->all();
            $emp = $data["emp"];

            $emp["empowermentId"] = Str::random(24);
            $emp["empowermentProductId"] = Str::random(24);

            $emp["agentPassportDateOfIssue"] = date('Y-m-d 00:00:00', strtotime($emp["agentPassportDateOfIssue"]));
            $emp["contractDate"] = date('Y-m-d 00:00:00', strtotime($emp["contractDate"]));
            $emp["empowermentDateOfExpire"] = date('Y-m-d 00:00:00', strtotime($emp["empowermentDateOfExpire"]));
            $emp["empowermentDateOfIssue"] = date('Y-m-d 00:00:00', strtotime($emp["empowermentDateOfIssue"]));

            DB::beginTransaction();

            Empowerment::create($emp);

            $this->saveEmpovermentProducts($data["products"], $emp["empowermentProductId"]);


            DB::commit();
            return ["message"=>"success", "ok"=>true];

        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Empowerment  $empowerment
     * @return \Illuminate\Http\Response
     */
    public function show($empowerment)
    {
        //
        return Empowerment::with(array('products', 'products.measure'))->find($empowerment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Empowerment  $empowerment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $empowerment)
    {
        //
        $data = $request->all();

        $emp = $data["emp"];

        $emp["agentPassportDateOfIssue"] = date('Y-m-d 00:00:00', strtotime($emp["agentPassportDateOfIssue"]));
        $emp["contractDate"] = date('Y-m-d 00:00:00', strtotime($emp["contractDate"]));
        $emp["empowermentDateOfExpire"] = date('Y-m-d 00:00:00', strtotime($emp["empowermentDateOfExpire"]));
        $emp["empowermentDateOfIssue"] = date('Y-m-d 00:00:00', strtotime($emp["empowermentDateOfIssue"]));

        $e = Empowerment::find($empowerment);

        DB::beginTransaction();
        try {
            $e->update($emp);

            $this->saveEmpovermentProducts($data["products"], $emp["empowermentProductId"]);
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
     * @param  \App\Models\Empowerment  $empowerment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Empowerment $empowerment)
    {
        //
        $empowerment->delete();
    }

    private function saveEmpovermentProducts($products, $empId){

        array_shift($products);
        try {
            EmpowermentProduct::where("empowermentProductId", $empId)->delete();

            foreach ($products as $product){
                $ep = new EmpowermentProduct();
                $ep->empowermentProductId = $empId;

                $ep->ordNo = $product[EmpowermentProduct::ORD_NO]["value"];
                $ep->count = $product[EmpowermentProduct::COUNT]["value"];
                $ep->measureId = $product[EmpowermentProduct::MEASURE_ID]["value"];
                $ep->name = $product[EmpowermentProduct::NAME]["value"];

                if(!$ep->save()){
                    throw new \Exception("Fail to save Empowerment product!");
                }
            }
        } catch (\Exception $exception){

            $exception->getMessage();
        }


    }
}
