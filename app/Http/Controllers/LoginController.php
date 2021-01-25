<?php

namespace App\Http\Controllers;

use App\Helper\LoginHelper;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function store(Request $request)
    {
        //
        try {
            $credentials = request()->only(['tin', 'password']);
            $token = LoginHelper::login($credentials);

            return [
                "token"=>$token,
                "user"=>$this->user()
            ];
        } catch (\Exception $exception){
            return $exception->getMessage();
        }
    }


}
