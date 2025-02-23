<?php

use App\Http\Controllers\Food\FoodApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('food')->group(function () {
    Route::get('/get-day-menu', [FoodApiController::class, 'getMenu']);
    Route::post('/send-order', [FoodApiController::class, 'sendOrder']);

    Route::get('/get-all-orders', [FoodApiController::class, 'getAllOrder']);
    Route::get('/state-support', [FoodApiController::class, 'getState']);


    Route::post('/test-get', [FoodApiController::class, 'getMenu']);
});


