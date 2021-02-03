<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpowermentProduct extends Model
{
    use HasFactory;

    const ORD_NO = 0;
    const NAME = 1;
    const MEASURE_ID = 2;
    const COUNT = 3;

    protected $guarded=[];

    public function empowerment(){
        return $this->belongsTo(Empowerment::class, 'empowermentProductId', 'empowermentProductId');
    }

    public function measure(){
        return $this->belongsTo(Measure::class, "measureId");
    }
}
