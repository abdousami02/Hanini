<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Food\AuthController as FoodAuthController;
use App\Http\Controllers\Food\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
    // return redirect()->route('food');
})->name('home');

Route::middleware('guest')->group(function (){
    Route::get('food/login', [FoodAuthController::class, 'index'])->name('food.login');
    Route::post('food/login-check', [FoodAuthController::class, 'login'])->name('food.login.check');


});

Route::middleware('auth')->group(function(){
    Route::get('logout', [FoodAuthController::class, 'logout'])->name('logout');
});

// Route::group(['prefix' => 'food'],function(){

//     // Route::get('/', [AuthController::class, 'index'])->name('food');
//     Route::get('/', [AuthController::class, 'index'])->name('login');
    
//     Route::group(['middleware' => 'auth-food'],function(){
//         Route::get('/dashboard', [DashboardController::class, 'index'])->name('food.dashboard');
    
        //notification
        Route::group(['prefix' => 'notification'], function () {
            Route::get('/all', [NotificationController::class, 'index'])->name('notification.all');
            Route::get('/status-change/{id}', [NotificationController::class, 'statusChange'])->name('notification.status.change');
            Route::get('/mark-seen', [NotificationController::class, 'markAllSeen'])->name('notification.all.seen');
            Route::get('/seen/{id}', [NotificationController::class, 'seen'])->name('notification.seen');
            Route::post('/delete', [NotificationController::class, 'destroy'])->name('notification.destroy');
        });

//     });
// });



