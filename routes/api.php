<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\CompanyController;
use \App\Http\Controllers\UserController;
use \App\Models\User;
use \App\Http\Controllers\FacturaController;
use \App\Http\Controllers\CompanyUserController;
use \App\Http\Controllers\FacturaProductController;
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

    //Route::group(["middleware"=>"auth:api,companies"], function (){

        Route::apiResource('company-user', CompanyUserController::class);

        //these are basic CRUD factura actions
        Route::apiResource('facturas', FacturaController::class);
        //these are for extra factura actions
        Route::get('facturas/get-pdf/{facturaId}', '\App\Http\Controllers\FacturaController@generatePdf')->name('facturas.get-pdf');

        Route::apiResource('factura-products', FacturaProductController::class);
        Route::post('factura-products/read-excel', 'App\Http\Controllers\FacturaProductController@importExcel')->name('factura-products-import');

        Route::apiResource('companies', CompanyController::class);
        Route::get('companies/tin/{tin}', '\App\Http\Controllers\CompanyController@getByTin')->name('companies.get-by-tin');

        Route::apiResource('users', UserController::class);

        Route::get('/me', function (Request $request) {

            if(auth()->user()){
                return auth()->user();
            }
            else if (auth()->guard('companies')){
                return auth()->guard('companies')->user();
            }
        });
//    });

    Route::post('company-login', '\App\Http\Controllers\CompanyController@login')->name('companies.login');

    Route::post('user-login', '\App\Http\Controllers\UserController@login')->name('users.login');

});



