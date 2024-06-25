<?php

use App\Models\Audience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\TopUpController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\RewardController;
use App\Http\Controllers\walletController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\RevenueController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\GreenCardController;
use App\Http\Controllers\IsabiSportController;
use App\Http\Controllers\WithdrawalController;
use App\Http\Controllers\CompanyUserController;
use App\Http\Controllers\transactionController;
use App\Http\Controllers\CampaignGameController;
use App\Http\Controllers\WalletRewardController;
use App\Http\Controllers\ArielCampaignController;
use App\Http\Controllers\AudienceLoginController;
use App\Http\Controllers\VendorCampaignController;
use App\Http\Controllers\VendorSpinWheelController;
use App\Http\Controllers\AudienceRegisterController;
use App\Http\Controllers\CampaignAudienceController;
use App\Http\Controllers\CampaignGameRuleController;
use App\Http\Controllers\CampaignQuestionController;
use App\Http\Controllers\CampaignReferralController;
use App\Http\Controllers\CampaignAdBreakerController;
use App\Http\Controllers\CampaignGamePrizeController;
use App\Http\Controllers\SpinWheelGamePlayController;
use App\Http\Controllers\WeeklyLeaderboardController;
use App\Http\Controllers\TransactionChannelController;
use App\Http\Controllers\CampaignLeaderboardController;
use App\Http\Controllers\RevenueDisbursementController;
use App\Http\Controllers\CampaignMobileRewardController;
use App\Http\Controllers\CampaignVoucherRewardController;
use App\Http\Controllers\VendorSpinWheelRewardController;
use App\Http\Controllers\CampaignGamePlayPurchaseController;
use App\Http\Controllers\CampaignReferralActivityController;
use App\Http\Controllers\CampaignSubscriptionPlanController;
use App\Http\Controllers\CampaignLeaderboardRewardController;
use App\Http\Controllers\CampaignLeaderboardRewardRedemptionController;

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
        //works
        $router->group(['prefix' => 'user'], function () use ($router) {
            $router->post('register', [RegisterController::class, 'clientRegister']); 
            $router->post('verify/otp', [RegisterController::class, 'verify']); 
            $router->post('create/pin', [RegisterController::class, 'createPIN']);
            $router->post('reset/pin', [RegisterController::class, 'resetPIN']); 
            $router->post('complete/pin/reset', [RegisterController::class, 'completePINReset']); 
            $router->post('login', [LoginController::class, 'login']);
          

        });

        //works
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

        //  Wallet (works)
        $router->group(['prefix' => 'wallets/'], function() use($router) {
            $router->post('create', [walletController::class, 'createWallet']);
            $router->post('debit', [walletController::class, 'debitWallet']);
            $router->post('credit', [walletController::class, 'creditWallet']);
            $router->get('{wallet_id}', [walletController::class, 'show']);
            $router->get('user/{user_id}', [walletController::class, 'showByUser']);


            //works
            $router->group(['prefix' => '{wallet_id}/transactions/'], function () use ($router) {
                $router->get('/', [transactionController::class, 'index']);
                $router->post('/histories', [transactionController::class, 'histories']);
            });
            $router->group(['prefix' => 'transactions/'], function () use ($router) {
                $router->get('{id}', [transactionController::class, 'show']);
            });

            // not tested
            $router->group(['prefix' => 'topup'], function () use ($router) {
                $router->post('/', [TopUpController::class, 'initializePayment']);
                $router->post('/verify-transaction', [TopUpController::class, 'verifyTransaction']);
            });

            // not tested
            $router->group(['prefix' => 'withdrawals'], function () use ($router) {
                $router->post('/', [WithdrawalController::class, 'initializeWithdraw']);
                $router->post('/verify', [WithdrawalController::class, 'verifyTransaction']);
            });
            
            // not tested (because of the GetBatchAudience)
            $router->group(['prefix' => 'revenues'], function () use ($router) {
                $router->get('campaign/{campaign_id}/daily-stats', [RevenueController::class, 'getDailyRevenueByCampaign']);
                $router->get('campaign/{campaign_id}/monthly-stats', [RevenueController::class, 'getMonthlyRevenueByCampaign']);
                $router->post('summary', [RevenueController::class, 'revenueSummary']);
            });

            // not tested
            $router->group(['prefix' => 'disburse/'], function () use ($router){
                $router->post('revenue', [RevenueDisbursementController::class, 'index']);
            });

            $router->group(['prefix' => 'rewards'], function () use ($router){
                $router->get('{audience_id}', [WalletRewardController::class, 'rewards']);
            });

        });

         //works
         $router->group(['prefix' => 'channels/'], function () use ($router) {
            $router->get('/', [TransactionChannelController::class, 'index']);
            $router->post('/', [TransactionChannelController::class, 'create']);
            $router->get('{id}', [TransactionChannelController::class, 'show']);
        });

       

        /// works
        // ARIEL CAMPAIGN ROUTES
        $router->group(['prefix' => 'ariel/campaign'], function () use ($router) {
            $router->get('/shoppingsites', [ArielCampaignController::class, 'getShoppingSites']);
            $router->get('/redeem/{code}', [ArielCampaignController::class, 'redeemReferralCode']);
            $router->post('/registeractivity', [ArielCampaignController::class, 'registerInfluencingActivities']);
            $router->post('/analytics', [ArielCampaignController::class, 'analytics']);

            //Emeka
            $router->post('/store-ariel-influencer', [ArielCampaignController::class, 'storeArielInfluencer']);
            $router->post('/store-shopping-site', [ArielCampaignController::class, 'storeShoppingSite']);
        });


        //WEEKLY LEADER-BOARD
        $router->group(['prefix' => 'weeklyleaderboard'], function () use ($router){
            $router->get('/', [WeeklyLeaderboardController::class, 'index']);
        });

        // works
        $router->group(['prefix' => 'media'], function() use ($router){
            $router->post('/', [MediaController::class, 'storeMedia']);
            $router->get('/', [MediaController::class, 'fetchMedia']);
        });


        // ARIEL CAMPAIGN ROUTE ENDS.

        // WORKS
        // MANAGE THE GAME PLAY PRIZE
        $router->group(['prefix' => 'game/prize/'], function () use ($router) {
            $router->get('/', [CampaignGamePrizeController::class, 'index']);
            $router->post('/', [CampaignGamePrizeController::class, 'store']);

        });

        

        //VENDOR SPIN-THE-WHEEL GAME
        // works (except reward);
        $router->group(['prefix' => 'vendor'], function () use ($router) {
            $router->get('/', [VendorSpinWheelController::class, 'index']);
            $router->post('/', [VendorSpinWheelController::class, 'store']);
            $router->post('spin/{campaign_id}/play', [VendorSpinWheelController::class, 'play']);
            $router->get('spin/{campaign_id}/redeem/{audience_id}', [VendorSpinWheelController::class, 'redeemVendorReward']);
            
            $router->group(['prefix' => 'reward'], function () use ($router) {
                $router->post('airtime/{campaign_id}', [VendorSpinWheelRewardController::class, 'airtimeReward']);
            });
            $router->group(['prefix' => 'campaign'], function () use ($router) {
                $router->get('{vendor_id}', [VendorCampaignController::class, 'index']);
                $router->post('{vendor_id}', [VendorCampaignController::class, 'storeCampaign']);
            });
        });

        $router->group(['prefix' => 'campaigns/'], function () use ($router) {
            //works
            $router->get('/active-campaigns', [CampaignController::class,'activeCampaigns']);
            $router->get('/fetch-campaigns/{title}', [CampaignController::class,'fetchCampaigns']);
            $router->post('/', [CampaignController::class,'storeInformation']);
            $router->get('/', [CampaignController::class,'index']);
        
            $router->group(['prefix' => '{campaign_id}/'], function () use ($router) {
                $router->get('/', [CampaignController::class,'show']); 
                // works with dummy value (except isabisport (no env provided))  
                $router->group(['prefix' => 'subscriptions/'], function () use ($router) {
                    $router->get('/audiencez/{audience_id}', [CampaignGamePlayPurchaseController::class, 'index']);
                    $router->post('/', [CampaignGamePlayPurchaseController::class, 'create']);
                    $router->get('/{id}',  [CampaignGamePlayPurchaseController::class, 'show']);
                    $router->get('/audiences/{audience_id}',  [CampaignGamePlayPurchaseController::class, 'getLatestSubscription']);
                    $router->patch('/audiences/{audience_id}', [CampaignGamePlayPurchaseController::class, 'consumeGameplay']);
                    $router->post('/freegameplays', [CampaignGamePlayPurchaseController::class, 'freeGamePlays']);
                    $router->post('/isabisport/initialize-charge', [IsabiSportController::class, 'initializeCharge']);
                    $router->post('/isabisport/charge-status', [IsabiSportController::class, 'verifyPayment']);
                });

                // works (admin route)
                $router->group(['prefix' => 'games/'], function () use ($router) {
                    $router->get('/', [CampaignGameController::class, 'index']);
                    $router->post('/', [CampaignGameController::class, 'store']);
                    $router->get('/{game_id}', [CampaignGameController::class, 'show']);
                    // $router->post('/play/start', [CampaignGameController::class, 'startNewGamePlay']);
                    // $router->post('/play/result', [CampaignGameController::class, 'registerGameActivity']);
                });

                // works
                $router->group(['prefix' => 'referrals/'], function () use ($router) {
                    $router->get('/', [CampaignReferralController::class, 'index']);
                    $router->post('/', [CampaignReferralController::class, 'create']);
                    // $router->post('/generateReferrerId', [CampaignReferralController::class, 'generateReferrerId']);
                    $router->get('/audiences-referral-points-today', [CampaignReferralController::class, 'referralCountForLeaderboard']);
                    $router->get('/{id}', [CampaignReferralController::class, 'show']);
                    $router->get('/{referrer_id}/referrer', [CampaignReferralController::class, 'showByReferrer']);
                

                    $router->group(['prefix' => 'activities'], function () use ($router) {
                        $router->post('/', [CampaignReferralActivityController::class, 'create']);
                        $router->get('/{id}', [CampaignReferralActivityController::class, 'show']);
                        $router->patch('/{referent_id}/activate-referent', [CampaignReferralActivityController::class, 'activateReferent']);
                        $router->patch('/{referrer_id}/claim-activation-point', [CampaignReferralActivityController::class, 'updateRedeemActivationPoint']);
                    });

                    $router->group(['prefix' => '{referral_id}/activities'], function () use ($router) {
                        $router->get('/', [CampaignReferralActivityController::class, 'index']);
                    });
                });

                // works
                $router->group(['prefix' => 'leaderboards/'], function() use ($router) {
                    $router->post('/', [CampaignLeaderboardController::class, 'storeLeaderBoard']);
                    $router->get('/daily', [CampaignLeaderboardController::class, 'showDaily']);
                    $router->get('/weekly', [CampaignLeaderboardController::class, 'showWeekly']);
                    $router->get('/monthly', [CampaignLeaderboardController::class, 'showMonthly']);
                    $router->get('/alltime', [CampaignLeaderboardController::class, 'showAllTime']);

                });


                // works
                $router->group(['prefix' => 'redemptions/'], function () use ($router) {
                    $router->post('/{audience_id}', [CampaignLeaderboardRewardRedemptionController::class, 'index']);
                    $router->get('/today/{audience_id}', [CampaignLeaderboardRewardRedemptionController::class, 'todayWinning']);
                });

                // works
                $router->group(['prefix' => 'rules/'], function () use ($router) {
                    $router->get('/', [CampaignGameRuleController::class, 'index']);
                    $router->post('/', [CampaignGameRuleController::class, 'create']);
                    $router->get('/{rule_id}', [CampaignGameRuleController::class, 'show']);
                });

                //works
                $router->group(['prefix' => 'subscription-plans/'], function () use ($router) {
                    $router->get('/', [CampaignSubscriptionPlanController::class, 'index']);
                    $router->post('/', [CampaignSubscriptionPlanController::class, 'create']);
                    $router->get('/{subscription_plan_id}', [CampaignSubscriptionPlanController::class, 'show']);
                });

                // works (but we need to register a campaignGamePlay to completely test it)
                $router->group(['prefix' => 'audiences/{audience_id}/'], function () use ($router) {
                    $router->get('stats/lastest-game-play', [CampaignAudienceController::class, 'leaderboardStatsLatestGamePlay']);
                });
    
                // works
                $router->group(['prefix' => 'questions'], function () use ($router) {
                    $router->get('/', [CampaignQuestionController::class, 'index']);
                    $router->post('/', [CampaignQuestionController::class, 'store']);
                });

                //Spin the wheel game play routes
                $router->group(['prefix' => 'spin/'], function () use ($router){
                    $router->get('/', [SpinWheelGamePlayController::class, 'initializeGameplay']);
                    $router->post('play', [SpinWheelGamePlayController::class, 'play']);
                    $router->post('play/free', [SpinWheelGamePlayController::class, 'playFree']);
                });
               
               // not tested
                $router->group(['prefix' => 'ad-breakers'], function () use ($router) {
                    $router->post('/save-ads-time', [CampaignAdBreakerController::class, 'saveAdsTime']);
                    $router->get('/save-ads-time', [CampaignAdBreakerController::class, 'getAdsTime']);
                    $router->get('/', [CampaignAdBreakerController::class, 'index']);
                    $router->post('/', [CampaignAdBreakerController::class, 'store']);
                    $router->get('/{ad_breaker_id}', [CampaignAdBreakerController::class, 'show']);
                    $router->post('/{ad_breaker_id}', [CampaignAdBreakerController::class, 'storeActivity']);
    
                });

                $router->group(['prefix' => 'rewards/'], function () use ($router) {
                    // works
                    $router->group(['prefix' => 'leaderboards/'], function () use ($router) {
                        $router->get('/', [CampaignLeaderboardRewardController::class, 'index']);
                        $router->post('/', [CampaignLeaderboardRewardController::class, 'store']);
                        $router->get('/{reward_id}', [CampaignLeaderboardRewardController::class, 'show']);
                        $router->post('/{reward_id}/audience/{audience_id}', [CampaignLeaderboardRewardController::class, 'storeRedemption']);
                    });

                    // not tested
                    $router->group(['prefix' => 'instant/mobile'], function () use ($router) {
                        $router->get('/', [CampaignMobileRewardController::class, 'index']);
                        $router->post('/', [CampaignMobileRewardController::class, 'store']);
                        $router->get('/{reward_id}', [CampaignMobileRewardController::class, 'show']);
                        $router->post('/{reward_id}/audience/{audience_id}', [CampaignMobileRewardController::class, 'storeRedemption']);
                    });
                    
                    // not tested
                    $router->group(['prefix' => 'vouchers'], function () use ($router) {
                        $router->post('/upload', [CampaignVoucherRewardController::class, 'upload']);
                    });

                    // not tested (get airtime rewards)
                    $router->group(['prefix' => 'airtime/'], function () use ($router) {
                        $router->get('{audience_id}', [RewardController::class, 'AirtimeRewards']);
                        $router->post('redeem/{audience_id}', [RewardController::class, 'redeemAirtime']);
                    });

                    //not tested get data bundle
                    $router->group(['prefix' => 'databundle'], function () use ($router) {
                        $router->get('{audience_id}', [RewardController::class, 'DatabundleRewards']);
                        $router->post('redeem/mtn/{audience_id}', [RewardController::class, 'redeemDatabundleMTN']); // MTN data
                        $router->post('redeem/airtel/{audience_id}', [RewardController::class, 'redeemDatabundleAIRTEL']); // AIRTEL data
                        $router->post('redeem/globacom/{audience_id}', [RewardController::class, 'GLO']); //GLO data
                        $router->post('redeem/9mobile/{audience_id}', [RewardController::class, 'MOBILE']); // 9MOBILE databundle
                    });
                    
                });

                //not tested (getaudience) GREEN CARD IMPLEMENTATION 
                $router->group(['prefix' => 'green-card'], function () use ($router){
                    $router->get('/winner-list', [GreenCardController::class, 'winnerList']);
                    $router->get('/subscription-price', [GreenCardController::class, 'getsubscriptionPrice']);
                    $router->get('/', [GreenCardController::class, 'index']);
                    $router->post('/', [GreenCardController::class, 'post']);
                    $router->get('/{audience_id}', [GreenCardController::class, 'listAudienceSubscription']);
                    $router->post('/raffle-draw', [GreenCardController::class, 'raffleDraw']);

                });
            });
        });

        // all the router below should be accessible by only authorized personnel(admin, company staff, superadmin)
        //works
        $router->group(['prefix' => 'companies/'], function () use ($router) {
            $router->get('/', [CompanyController::class, 'index']);
            $router->post('/', [CompanyController::class, 'storeCompany']);
        });

        //works
        $router->group(['prefix' => 'company-user/'], function () use ($router) {
            $router->get('/', [CompanyUserController::class, 'indexCompanyUser']);
            $router->post('/', [CompanyUserController::class, 'storeCompanyUser']);
        });

        //works
        $router->group(['prefix' => 'brands/'], function () use ($router) {
            $router->get('/', [BrandController::class, 'index']);
            $router->post('/', [BrandController::class, 'storeBrand']);
        });

        //works
        $router->group(['prefix' => 'clients/'], function () use ($router) {
            $router->get('/', [ClientController::class, 'index']);
            $router->post('/', [ClientController::class, 'storeClient']);
        });

        //works
        $router->group(['prefix' => 'games/'], function() use ($router) {
            // validate if we just have one game to one campaign
            $router->get('/', [GameController::class, 'index']);
            $router->post('/', [GameController::class, 'storeGame']);

            $router->group(['prefix' => '{game_id}/'], function() use ($router) {
                $router->get('show-game', [GameController::class, 'showGame']);
                $router->put('update-game', [GameController::class, 'updateGame']);
            });
            
            

        });

        //works
        $router->group(['prefix' => 'campaign-game-rule/'], function () use ($router) {
            $router->get('/', [CampaignGameRuleController::class, 'indexCampaignGameRule']);
            $router->post('/', [CampaignGameRuleController::class, 'storeCampaignGameRuleController']);
        });
       

   });
    // not working
    // $router->post('v1/audience/logout', [AudienceLoginController::class, 'audienceLogout']);
    // $router->post('v1/user/logout', [LoginController::class, 'logout']);
});


