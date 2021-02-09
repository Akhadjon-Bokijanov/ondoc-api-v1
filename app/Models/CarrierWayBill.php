<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarrierWayBill extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function products(){
        return $this->hasMany(WaybillingItem::class,  "waybilling_id", "wayBillProductId");
    }
}
