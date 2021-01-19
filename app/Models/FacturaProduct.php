<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacturaProduct extends Model
{
    use HasFactory;

    public function factura(){
        return $this->belongsTo(Factura::class, 'facturaProductId', 'facturaProductId')->orderBy('ordNo', 'asc');
    }

    public function measure(){
        return $this->belongsTo(Measure::class, "measureId");
    }
}
