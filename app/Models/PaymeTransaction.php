<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymeTransaction extends Model
{
    use HasFactory;

    protected $casts = [
        'perform_time' => 'integer',
        'transaction_create_time' => 'integer',
        'cancel_time' => 'integer',
        'create_time' => 'integer',
    ];
}
