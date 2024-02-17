<?php

use App\Http\Controllers\CampaignController;
use App\Http\Controllers\CampaignGameController;
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

Route::group(['prefix' => 'v1/'], function () use ($router) {
    $router->group(['prefix' => 'auth/'], function () use ($router) {
        $router->post('register', [RegisterController::class, 'clientRegister']); 
        $router->post('verify/otp', [RegisterController::class, 'verify']); 
        $router->post('create/pin', [RegisterController::class, 'createPIN']);
        $router->post('reset/pin', [RegisterController::class, 'resetPIN']); 
        $router->post('complete/pin/reset', [RegisterController::class, 'completePINReset']); 
        $router->post('login', [LoginController::class, 'login']);
    });

<<<<<<< HEAD
    $router->group(['prefix' => 'campaigns/'], function () use ($router) {
        $router->get('/active-campaigns', [CampaignController::class,'activeCampaigns']);
        $router->get('/fetch-campaigns/{title}', [CampaignController::class,'fetchCampaigns']);
        $router->post('/', [CampaignController::class,'storeInformation']);
        // $router->get('/', [CampaignController::class,'index']);

        $router->group(['prefix' => '{campaign_id}/'], function () use ($router) {
            $router->get('/', [CampaignController::class,'show']);          
            $router->group(['prefix' => 'games/'], function () use ($router) {
                $router->get('/', [CampaignGameController::class, 'index']);
                $router->post('/', [CampaignGameController::class, 'store']);
                $router->get('/{game_id}', [CampaignGameController::class, 'show']);
                // $router->post('/play/start', [CampaignGameController::class, 'startNewGamePlay']);
                // $router->post('/play/result', [CampaignGameController::class, 'registerGameActivity']);
            });
        });
    });
=======
>>>>>>> e0249016ac642e59aea953a090e05089b5033df9
});

