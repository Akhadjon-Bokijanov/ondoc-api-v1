<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        "tin",
        "parentId",
        "tin",
        "ns10Code",
        "ns11Code",
        "districtId",
        "companyName",
        "address",
        "oked",
        "tariffId",
        "directorTin",
        "directorName",
        "accountant",
        "regCode",
        "mfo",
        "phone",
        "status",
        "type",
        "isAferta",
        "isOnline",
        "countLogin",
        "lastLoginAt",
        "afertaText"
    ];

    public function users(){
        return $this->belongsToMany(User::class);
    }
}
