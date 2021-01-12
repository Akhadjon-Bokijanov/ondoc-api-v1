<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empowerment extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function products(){
        return $this->hasMany(EmpowermentProduct::class, 'empowermentProductId', 'empowermentProductId');
    }
}
