<?php

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


/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/',[App\Http\Controllers\ProductController::class,'index']);
Route::get('/produtdetail/{id}',[App\Http\Controllers\ProductController::class,'show']);

Route::post('payment/process-payment/{string}/{price}', [App\Http\Controllers\PaymentController::class, 'processPayment'])->name('processPayment');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
