<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::group(['namespace' => 'auth'], function () {
    Route::post('register', [RegisterController::class,'clientRegister']);
});

Route::get('/', function () {
    return "HOME";
});

Route::group(['prefix' => 'v1/auth'], function () use ($router) {

    $router->post('register', [RegisterController::class, 'clientRegister']); 
    $router->post('verify/otp', [RegisterController::class, 'verify']); 
    $router->post('create/pin', [RegisterController::class, 'createPIN']);
    $router->post('reset/pin', [RegisterController::class, 'resetPIN']); 
    $router->post('complete/pin/reset', [RegisterController::class, 'completePINReset']); 
    $router->post('login', [LoginController::class, 'login']);


});

