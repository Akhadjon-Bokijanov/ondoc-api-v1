<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacturaProduct extends Model
{
    use HasFactory;

    public function factura(){
        $this->belongsTo(Factura::class);
    }
}
