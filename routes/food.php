<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Food\DashboardController;
use App\Http\Controllers\Food\OrderController;
use App\Http\Controllers\Food\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Food Routes
|--------------------------------------------------------------------------
|
*/


Route::group(['prefix' => 'food','middleware' => 'auth.food'],function(){
    
    Route::get('/', [DashboardController::class, 'index'])->name('food');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('food.dashboard');

    Route::get('/orders', [OrderController::class, 'index'])->name('food.orders');

    Route::get('/products', [ProductController::class, 'index'])->name('food.products');
    Route::get('/product/add', [ProductController::class, 'create'])->name('food.product.add');


    
        // //notification
        // Route::group(['prefix' => 'notification'], function () {
        //     Route::get('/all', [NotificationController::class, 'index'])->name('notification.all');
        //     Route::get('/status-change/{id}', [NotificationController::class, 'statusChange'])->name('notification.status.change');
        //     Route::get('/mark-seen', [NotificationController::class, 'markAllSeen'])->name('notification.all.seen');
        //     Route::get('/seen/{id}', [NotificationController::class, 'seen'])->name('notification.seen');
        //     Route::post('/delete', [NotificationController::class, 'destroy'])->name('notification.destroy');
        // });
});



