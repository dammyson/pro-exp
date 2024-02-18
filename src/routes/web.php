<?php

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
});


Route::resource('company', App\Http\Controllers\CompanyController::class)->only('index', 'store');

Route::resource('client', App\Http\Controllers\ClientController::class)->only('index', 'store');

Route::resource('brand', App\Http\Controllers\BrandController::class)->only('index', 'store');
