<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "fio",
        "dateOfBirth",
        "gender",
        "phone",
        "lang",
        "tin",
        "roleId",
        "auth_key",
        "status",
        "email",
        "password",
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

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function companies(){
        return $this->belongsToMany(Company::class)->withPivot('isActive', 'roleId');
    }

    public function sentFacturas(){
        return $this->hasMany(Factura::class, 'tin', 'sellerTin');
    }

    public function receivedFacturas(){
        return $this->hasMany(Factura::class, 'tin', 'buyerTin');
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
