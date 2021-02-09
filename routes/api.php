<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\CompanyController;
use \App\Http\Controllers\UserController;
use \App\Http\Controllers\FacturaController;
use \App\Http\Controllers\CompanyUserController;
use \App\Http\Controllers\FacturaProductController;
use \App\Http\Controllers\CabinetController;
use \App\Http\Controllers\LoginController;
use \App\Http\Controllers\ContractController;
use \App\Http\Controllers\ActController;
use \App\Http\Controllers\EmpowermentController;
use \App\Http\Controllers\CarrierWayBillController;
use \App\Http\Controllers\PaymeTransactionController;
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

    Route::group(["middleware"=>["auth:api,companies","cors"]], function (){

        Route::apiResource('company-user', CompanyUserController::class);

        Route::apiResource('cabinet', CabinetController::class);

        //these are basic CRUD document actions
        Route::apiResource('acts', ActController::class);

        Route::apiResource('contracts', ContractController::class);

        Route::apiResource('facturas', FacturaController::class);

        Route::apiResource('empowerments', EmpowermentController::class);

        Route::apiResource('ttys', CarrierWayBillController::class);

        //these are for extra document actions


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
    });

    Route::apiResource('payme', PaymeTransactionController::class);

    Route::apiResource("login-with-password", LoginController::class);
    Route::get('{docType}/get-pdf/{facturaId}', "\App\Helper\PdfHelper@generatePdf")->name('pdfs.get-pdf');

});



