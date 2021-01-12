<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Company extends Authenticatable implements JWTSubject
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

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token'
    ];

    public function facturas(){
        return $this->hasMany(Factura::class);
    }

    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function getJWTIdentifier()
    {
        // TODO: Implement getJWTIdentifier() method.
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        // TODO: Implement getJWTCustomClaims() method.
        return [];
    }
}
