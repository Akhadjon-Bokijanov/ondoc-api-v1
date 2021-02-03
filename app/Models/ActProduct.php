<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActProduct extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function act(){
        return $this->belongsTo(Act::class, "actId", "actId");
    }

    public function measure(){
        return $this->belongsTo(Measure::class, "measureId");
    }
}
