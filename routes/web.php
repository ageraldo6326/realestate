<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\Productdetails;
use App\Http\Controllers\Frontend\ShopController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/',[HomeController::class,'index'])->name('home');
Route::get('/product-details/{id}',[Productdetails::class,'show'])->name('product-details');

Route::get('/login/',function () {
    return view('auth.login');
})->name('login');

Route::get('/logout/',function () {
    Auth::logout;
})->name('logout');


Route::get('/shop-right-sidebar',[ShopController::class,'index'])->name('tienda');
