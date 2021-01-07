<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\CompanyController;
use \App\Http\Controllers\UserController;

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

    Route::apiResource('companies', CompanyController::class);

    Route::apiResource('users', UserController::class);

});


Route::middleware('auth')->get('/user/{userId}', function (Request $request, $userId) {
    var_dump($userId);
    die();
    return $request->user();
});
