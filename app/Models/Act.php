<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Act extends Model
{
    use HasFactory;

    const ORD_NO=0;
    const NAME=1;
    const MEASURE_ID=2;
    const COUNT=3;
    const PRICE=4;

    protected $guarded =[];

    public function actProducts(){
        return $this->hasMany(ActProduct::class, 'actId', 'actId');
    }

    protected static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub

        static::deleting(function($act){
            $act->actProducts()->delete();
        });
    }

}
