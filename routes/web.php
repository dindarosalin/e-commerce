<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Seller\SellerController;
use App\Http\Controllers\Buyer\BuyerController;

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
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// TESTING
Route::get('/admin', function () {
    return 'Welcome Admin';
})->middleware('role:Admin');

Route::get('/superadmin', function () {
    return 'Welcome Super Admin';
})->middleware('role:Super Admin');

Route::get('/user', function () {
    return 'Welcome User';
})->middleware('role:User');

//Protected Route
Route::middleware(['auth','role:Super Admin'])->group(function(){
    Route::resource('roles', RoleController::class);
});

Route::middleware(['auth','role:Admin'])->group(function(){
    // Route::resource('roles', RoleController::class);
});

Route::middleware(['auth','role:User'])->group(function(){
    // Route::resource('roles', RoleController::class);
});

Route::middleware(['auth','role:Seller'])->group(function(){
    Route::resource('roles', SellerController::class);
});

Route::middleware(['auth','role:Buyer'])->group(function(){
    Route::resource('roles', BuyerController::class);
});