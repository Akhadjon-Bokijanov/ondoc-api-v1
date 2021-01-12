<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpowermentProduct extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function empowerment(){
        return $this->belongsTo(Empowerment::class, 'empowermentProductId', 'empowermentProductId');
    }
}
