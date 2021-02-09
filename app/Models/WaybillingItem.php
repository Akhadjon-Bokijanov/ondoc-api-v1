<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaybillingItem extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function carrierWayBill(){
        return $this->belongsTo(CarrierWayBill::class, "waybilling_id", "wayBillProductId");
    }

    public function measure(){
        return $this->belongsTo(Measure::class, "measureId");
    }
}
