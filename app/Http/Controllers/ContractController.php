<?php

namespace App\Http\Controllers;

use App\Helper\RoumingHelper;
use App\Models\Contract;
use App\Models\ContractPart;
use App\Models\ContractProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $contracts = Contract::where(function ($q){
            $user = $this->user();
            $q->where('sellerTin', $user->tin)
                ->orWhere("buyerTin", $user->tin);
        })->get();

        return $contracts;
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

            //return $data;
            //var_dump($data);
            //die();
            $contractId = RoumingHelper::getDocID();
            $contract = $data["contract"];
            $contract["contractId"] = $contractId;

            $contract["contractDate"] = date('Y-m-d 00:00:00', strtotime($contract["contractDate"]));
            $contract["contractExpireDate"] = date('Y-m-d 00:00:00', strtotime($contract["contractExpireDate"]));

            DB::beginTransaction();
            try {
                $this->saveContractParts($data["parts"], $contractId);
                $this->saveContractProducts($data["products"], $contractId);
                Contract::create($contract);

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
     * @param  \App\Models\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function show($contract)
    {
        //
        return Contract::with(["contractProducts", "contractParts"])->find($contract);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $c)
    {
        //
        try {
            $data = $request->all();
            $contract = $data["contract"];
            DB::beginTransaction();
            try {
                $c = Contract::find($c);
                $contract["contractDate"] = date('Y-m-d 00:00:00', strtotime($contract["contractDate"]));
                $contract["contractExpireDate"] = date('Y-m-d 00:00:00', strtotime($contract["contractExpireDate"]));
                $c->update($contract);
                $this->saveContractParts($data["parts"], $contract["contractId"]);
                $this->saveContractProducts($data["products"], $contract["contractId"]);
            } catch (\Exception $exception){
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contract $contract)
    {
        //
        $contract->delete();
    }

    public function saveContractProducts($products, $contractId){
        try {

            array_shift($products);
            ContractProduct::where('contract_id', $contractId)->delete();

            foreach ($products as $product){
                if ($product){
                    $p = new ContractProduct();

                    $p->contract_id = $contractId;
                    $p->ordNo = $product[ContractProduct::ORD_NO]["value"];
                    $p->name = $product[ContractProduct::NAME]["value"];
                    $p->catalogCode=$product[ContractProduct::CATALOG_CODE]["value"];
                    $p->catalogName = "TO BE INSERTED";
                    $p->barCode = $product[ContractProduct::BAR_CODE]["value"];
                    $p->price = $product[ContractProduct::PRICE]["value"];
                    $p->deliverySum = $product[ContractProduct::DELIVERY_SUMM]["value"];
                    $p->measureId = $product[ContractProduct::MEASURE_ID]["value"];
                    $p->count = $product[ContractProduct::COUNT]["value"];

                    if (!$p->save()){
                        throw new \Exception("Product not saved", 500);
                    }
                }
            }

        } catch (\Exception $exception){
            throw new \Exception($exception->getMessage());
        }
    }

    public function saveContractParts($parts, $contractId){

        try {

            ContractPart::where('contract_id', $contractId)->delete();

            foreach ($parts as $part){
                $part["contract_id"] = $contractId;
                ContractPart::create($part);
            }
        }catch (\Exception $exception){
            throw new \Exception($exception->getMessage());
        }

    }

}
