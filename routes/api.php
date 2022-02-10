<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\OrderController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function() {
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('customers', CustomerController::class);
    Route::apiResource('items', ItemController::class);
    Route::apiResource('orders', OrderController::class);
    Route::apiResource('users', OrderController::class);
});

//  Autenticación por JWT
/* Route::group([ 'middleware' => 'api', 'prefix' => 'auth'], function() {
    Route::post('login', [AuthJWTController::class, 'login']);
    Route::post('logout', [AuthJWTController::class, 'logout']);
    Route::post('refresh', [AuthJWTController::class, 'refresh']);
    Route::post('me', [AuthJWTController::class, 'me']);
}); */     

// Autenticación con Laravel Sanctum
Route::group([ 'middleware' => 'api', 'prefix' => 'auth'], function() {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    
    Route::middleware('auth:sanctum')->group(function() {
        Route::get('profile', [AuthController::class, 'profile']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::post('logout', [AuthController::class, 'logout']);
    });
});

