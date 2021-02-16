<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaybillingItem extends Model
{
    use HasFactory;

    protected $guarded=[];

    const NAME = 1;
    const MEASEURE_ID = 2;
    const COUNT = 3;
    const PRICE = 4;
    const DELIVERY_PRICE = 6;
    const DELIVERY_DOCS = 7;
    const MEASURE_METHOD = 8;
    const ITEM_CLASS = 9;
    const BRUTTO_WEIGHT = 10;
    const NETTO_WEIGHT=11;

    public function carrierWayBill(){
        return $this->belongsTo(CarrierWayBill::class, "waybilling_id", "wayBillProductId");
    }

    public function measure(){
        return $this->belongsTo(Measure::class, "measureId");
    }
}
