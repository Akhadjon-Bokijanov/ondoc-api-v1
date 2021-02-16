<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    const DOC_STATUS_SAVED = 1;
    const DOC_STATUS_WAIT = 2;
    const DOC_STATUS_SEND = 3;
    const DOC_STATUS_CANCELLED = 4;
    const DOC_STATUS_REJECTED = 5;
    const DOC_STATUS_ACCEPTED = 6;
    const DOC_STATUS_SEND_ACCEPTED = 7;

    public static function user(){
        if (auth()->guard('api')->check()){
            $user = auth()->user();
            $user["user_type"] = "user";
            return $user;
        }
        else if (auth()->guard('companies')->check()){
            $user = auth("companies")->user();
            $user["user_type"] = "company";
            return $user;
        }
        return null;
    }

}
