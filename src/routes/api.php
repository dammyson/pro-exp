<?php

use App\Models\Audience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\CompanyUserController;
use App\Http\Controllers\CampaignGameController;
use App\Http\Controllers\AudienceLoginController;
use App\Http\Controllers\AudienceRegisterController;
use App\Http\Controllers\CampaignGameRuleController;
use App\Http\Controllers\CampaignLeaderboardController;

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


Route::group(['prefix' => 'v1/'], function () use ($router) {
    
    $router->group(['prefix' => 'auth/'], function () use ($router) {
        $router->group(['prefix' => 'user'], function () use ($router) {
            $router->post('register', [RegisterController::class, 'clientRegister']); 
            $router->post('verify/otp', [RegisterController::class, 'verify']); 
            $router->post('create/pin', [RegisterController::class, 'createPIN']);
            $router->post('reset/pin', [RegisterController::class, 'resetPIN']); 
            $router->post('complete/pin/reset', [RegisterController::class, 'completePINReset']); 
            $router->post('login', [LoginController::class, 'login']);
          

        });

        $router->group(['prefix' => 'audience'], function () use ($router) {
            $router->post('register', [AudienceRegisterController::class, 'audienceRegister']); 
            $router->post('verify/otp', [AudienceRegisterController::class, 'audienceVerify']); 
            $router->post('create/pin', [AudienceRegisterController::class, 'audienceCreatePIN']);
            $router->post('reset/pin', [AudienceRegisterController::class, 'audienceResetPIN']); 
            $router->post('complete/pin/reset', [AudienceRegisterController::class, 'audienceCompletePINReset']); 
            $router->post('login', [AudienceLoginController::class, 'audienceLogin']);
           

        });
    });
});

Route::middleware(['auth.multiple:api,audience'])->group(function ($router) {

    Route::group(['prefix' => 'v1/'], function () use ($router) {
        $router->group(['prefix' => 'campaigns/'], function () use ($router) {
            $router->get('/active-campaigns', [CampaignController::class,'activeCampaigns']);
            $router->get('/fetch-campaigns/{title}', [CampaignController::class,'fetchCampaigns']);
            $router->post('/', [CampaignController::class,'storeInformation']);
            $router->get('/', [CampaignController::class,'index']);
        
            $router->group(['prefix' => '{campaign_id}/'], function () use ($router) {
                $router->get('/', [CampaignController::class,'show']);          
                $router->group(['prefix' => 'games/'], function () use ($router) {
                    $router->get('/', [CampaignGameController::class, 'index']);
                    $router->post('/', [CampaignGameController::class, 'store']);
                    $router->get('/{game_id}', [CampaignGameController::class, 'show']);
                    // $router->post('/play/start', [CampaignGameController::class, 'startNewGamePlay']);
                    // $router->post('/play/result', [CampaignGameController::class, 'registerGameActivity']);
                });
                $router->group(['prefix' => 'leaderboards/'], function() use ($router) {
                    $router->post('/', [CampaignLeaderboardController::class, 'storeLeaderBoard']);
                    $router->get('/daily', [CampaignLeaderboardController::class, 'showDaily']);
                    $router->get('/weekly', [CampaignLeaderboardController::class, 'showWeekly']);
                    $router->get('/monthly', [CampaignLeaderboardController::class, 'showMonthly']);
                    $router->get('/alltime', [CampaignLeaderboardController::class, 'showAllTime']);

                });
              
            });
        });


        $router->group(['prefix' => 'companies/'], function () use ($router) {
            $router->get('/', [CompanyController::class, 'index']);
            $router->post('/', [CompanyController::class, 'storeCompany']);
        });

        $router->group(['prefix' => 'company-user/'], function () use ($router) {
            $router->get('/', [CompanyUserController::class, 'indexCompanyUser']);
            $router->post('/', [CompanyUserController::class, 'storeCompanyUser']);
        });

        $router->group(['prefix' => 'brands/'], function () use ($router) {
            $router->get('/', [BrandController::class, 'index']);
            $router->post('/', [BrandController::class, 'storeBrand']);
        });

        $router->group(['prefix' => 'clients/'], function () use ($router) {
            $router->get('/', [ClientController::class, 'index']);
            $router->post('/', [ClientController::class, 'storeClient']);
        });

        $router->group(['prefix' => 'games/'], function() use ($router) {
            // validate if we just have one game to one campaign
            $router->get('/', [GameController::class, 'index']);
            $router->post('/', [GameController::class, 'storeGame']);

            $router->group(['prefix' => '{game_id}/'], function() use ($router) {
                $router->get('show-game', [GameController::class, 'showGame']);
                $router->put('update-game', [GameController::class, 'updateGame']);
            });
            
            

        });

        $router->group(['prefix' => 'campaign-game-rule/'], function () use ($router) {
            $router->get('/', [CampaignGameRuleController::class, 'indexCampaignGameRule']);
            $router->post('/', [CampaignGameRuleController::class, 'storeCampaignGameRuleController']);
        });
       

   });
    // not working
    // $router->post('v1/audience/logout', [AudienceLoginController::class, 'audienceLogout']);
    // $router->post('v1/user/logout', [LoginController::class, 'logout']);
});


