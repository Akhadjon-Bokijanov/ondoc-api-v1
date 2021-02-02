<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractProduct extends Model
{
    use HasFactory;

    const ORD_NO=0;
    const NAME=1;
    const CATALOG_CODE = 2;
    const BAR_CODE = 3;
    const MEASURE_ID = 4;
    const COUNT = 5;
    const PRICE = 6;
    const DELIVERY_SUMM=7;

    protected $guarded=[];

    public function contract(){
        return $this->belongsTo(Contract::class, "contractId", "contract_id");
    }

    public function measure(){
        return $this->belongsTo(Measure::class, "measureId");
    }
}
