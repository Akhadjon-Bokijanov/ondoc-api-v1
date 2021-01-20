<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacturaProduct extends Model
{
    use HasFactory;

    //FACTURA PRODUCT INDEXES IN TABLE
    const ORD_NO = 0;
    const PRODUCT_NAME = 1;
    const CATALOGE_CODE = 2;
    const BAR_CODE = 3;
    const MEASURE = 4;
    const AMOUNT = 5;
    const PRICE = 6;
    const EXCISE_RATE = 7;
    const EXCISE_AMOUNT = 8;
    const DELIVERY_PRICE = 9;
    const VAT_RATE= 10;
    const VAT_AMOUNT = 11;
    const DELIVERY_SUM_WITH_VAT_EXCISE = 12;

    public function factura(){
        return $this->belongsTo(Factura::class, 'facturaProductId', 'facturaProductId')->orderBy('ordNo', 'asc');
    }

    public function measure(){
        return $this->belongsTo(Measure::class, "measureId");
    }
}
