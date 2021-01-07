<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\CompanyController;
use \App\Http\Controllers\UserController;
use \App\Models\User;
use \App\Models\Factura;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function (){

    //for authenticated routes structure:
    //header
    //      Authorization: Bearer [token]
    //body
    //      body data

    Route::group(["middleware"=>"auth"], function (){

        Route::apiResource('facturas', Factura::class);

        Route::apiResource('companies', CompanyController::class);

        Route::apiResource('users', UserController::class);

        Route::get('/me', function (Request $request) {
            return auth()->user();
        });
    });

    Route::post('new-user', function (Request $request){
        try {
            $data = $request->all();
            $data["password"] = Hash::make($data["password"]);
            $data["auth_key"] = md5($data["tin"].$data["fio"]);

            $user = User::create($data);
            return $user;
        }catch (Exception $exception){
            return $exception->getMessage();
        }
    });

    Route::post('/login', function (Request $request){
        $credentials = request()->only(['tin', 'password']);
        $token = auth()->attempt($credentials);

        return [
            "token"=>$token,
            "user"=>auth()->user()
        ];
    });




});



