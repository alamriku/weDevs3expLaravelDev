<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;

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
Route::get('/setCook',function (){
    Cookie::queue(
        'refresh_token',
        "testset",
        14400 // 10 days
    );
});
Route::get('/getCook',function (){
    dd(request()->cookie('refresh_token'));
});
Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('refresh-token', [AuthController::class, 'refreshToken'])->middleware('guest')->name('refreshToken');
    });

    Route::group(['middleware'=>'auth:api'],function (){
        Route::post('logout', [AuthController::class, 'logout']);
        Route::Resource('products',ProductController::class);
    });

});


