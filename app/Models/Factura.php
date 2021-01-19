<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function user(){
        return $this->belongsTo(User::class, 'sellerTin', 'tin');
    }

    public function company(){
        return $this->belongsTo(Company::class, 'sellerTin', 'tin');
    }

    public function facturaProducts(){
        return $this->hasMany(FacturaProduct::class,'facturaProductId', 'facturaProductId');
    }

}
