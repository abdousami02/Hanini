<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Food\MediaController;
use App\Http\Controllers\Food\OrderController;
use App\Http\Controllers\Food\ProductController;
use App\Http\Controllers\Food\DashboardController;
use App\Http\Controllers\Food\SellerController;
use App\Http\Controllers\Food\UserController;

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
    Route::get('/order-details/{id}', [OrderController::class, 'details'])->name('food.order.details');
    Route::post('/order/destroy', [OrderController::class, 'destroy'])->name('food.order.destroy');

    Route::post('/order/change-status', [OrderController::class, 'changeStatus'])->name('food.order.change.status');


    Route::get('/products', [ProductController::class, 'index'])->name('food.products');
    Route::get('/product/add', [ProductController::class, 'add'])->name('food.product.add');
    Route::post('/product/store', [ProductController::class, 'store'])->name('food.product.store');
    Route::get('/product/edit/{id}', [ProductController::class, 'edit'])->name('food.product.edit');
    Route::post('/product/update/{id}', [ProductController::class, 'update'])->name('food.product.update');
    Route::post('/product/destroy', [ProductController::class, 'destroy'])->name('food.product.destroy');


    Route::post('/upload-file', [MediaController::class, 'uploadEditor'])->name('editor.upload');

    Route::get('/users', [UserController::class, 'index'])->name('food.users');
    Route::get('/sellers', [SellerController::class, 'index'])->name('food.sellers');

        // //notification
        // Route::group(['prefix' => 'notification'], function () {
        //     Route::get('/all', [NotificationController::class, 'index'])->name('notification.all');
        //     Route::get('/status-change/{id}', [NotificationController::class, 'statusChange'])->name('notification.status.change');
        //     Route::get('/mark-seen', [NotificationController::class, 'markAllSeen'])->name('notification.all.seen');
        //     Route::get('/seen/{id}', [NotificationController::class, 'seen'])->name('notification.seen');
        //     Route::post('/delete', [NotificationController::class, 'destroy'])->name('notification.destroy');
        // });
});

Route::post('/food-product-status-change', [ProductController::class, 'changeStatus'])->name('food.product.change-status');




