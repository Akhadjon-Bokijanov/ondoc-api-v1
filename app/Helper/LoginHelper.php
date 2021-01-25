<?php

namespace App\Helper;


use App\Models\Company;
use App\Models\User;

class LoginHelper {

    public static function login($credentials){
        if (User::where('tin', '=', $credentials["tin"])->count() > 0){
            return auth()->attempt($credentials);
        }
        else if (Company::where('tin', '=', $credentials["tin"])->count() > 0){
            return auth('companies')->attempt($credentials);
        }

        //IF NEITHER USER NOR COMPANY FOUND
        return false;
    }
}
