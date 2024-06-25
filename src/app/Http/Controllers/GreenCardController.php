<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\GreenCard;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Audience;
use App\Models\CampaignSubscription;
use Illuminate\Support\Facades\Http;
use App\Models\CampaignSubscriptionPlan;


class GreenCardController extends Controller
{
    //
    public function index($campaign_id) {
        try {
            $data = GreenCard::where('campaign_id', $campaign_id)->get();

            foreach ($data as $subscription) 
            {
                $month = Carbon::now()->format('m');
                $subscription->status = Carbon::parse($subscription->created_at)->format('m') == $month ? 'active' : 'expired';

            }
        } catch (\Exception $exception){
            //report($exception);
            return response()->json(['status' => false, 'message' => $exception->getMessage()], 500);
        }

        return response()->json([
            'error' => false,
            'message' => 'Green Card Subscriptions',
            'data' => $data
        ]);
    }

    public function post(Request $request, $campaign_id)
    {
        $validated = $this->validate($request, [
            'audience_id' => 'required|uuid'
        ]);

        try {
            $getsubscriptionplan = CampaignSubscriptionPlan::where('campaign_id', $campaign_id)->first();
            if ($getsubscriptionplan == null)
            {
                return response()->json([
                    'error' => true,
                    'message' => 'invalid campaign ID'
                ], 400);
            }

            $month = Carbon::now()->format('m');
            $getValidDate = GreenCard::whereMonth('date', $month)->where('audience_id', $validated['audience_id'])->first();
            if ($getValidDate)
            {
              return response()->json([
                'error' => true,
                'message' => 'Cannot perform this action again this month'
              ], 400);  
            }

            $checkIfAlreadySubscribed =  CampaignSubscription::where('audience_id', $validated['audience_id'])
                ->where('campaign_id', $campaign_id)
                ->first();
            
            if ($checkIfAlreadySubscribed == null)
            {
                $payload = [
                    'wallet_id' => $validated['audience_id'],
                    'amount' => $getsubscriptionplan->price, //$rule->pay_as_you_go_amount,
                    'platform' => 'arena', //update this later by getting platform name from .env
                    'trans_type' => 'green-card-subcription',
                    'reference' => $campaign_id
                ];

                $wallet_response = Http::post(env('WALLET_BASE_URL').'/debit', $payload);
                if ($wallet_response->serverError() || $wallet_response->clientError())
                {
                    return response()->json([
                        'message' => $wallet_response->json(),
                        'redirect_to_wallet_page' => true
                    ], 400);
                }
            } 
            
            //registration subscription
            $camSubs = CampaignSubscription::create([
                'campaign_id' => $campaign_id,
                'audience_id' => $validated['audience_id'],
                'campaign_subscription_plan_id' => $getsubscriptionplan->id,
                'payment_reference' => Str::random(32),
                'allocated_game_plays' => 1,
                'available_game_plays' => 1
            ]);

            $createGreenCardSubscription = GreenCard::create([
                'campaign_id' => $campaign_id,
                'audience_id' => $validated['audience_id'],
                'campaign_subscription_plan_id' => $getsubscriptionplan,
                'ticket_number' => uniqid(),
                'date' => Carbon::now()->format('y-m-d')
            ]);

            $data['campaign_subs'] = $camSubs;
            $data['green_Card'] = $createGreenCardSubscription;
        } catch (\Exception $exception){
            //report($exception);
            return response()->json(['status' => false, 'message' => $exception->getMessage()], 500);
        }

        return response()->json([
            'error' => false, 
            'message' => 'Green Card Subscriptions Completed'
        ], 201);

    }

    public function raffleDraw(Request $request, $campaign_id)
    {
        try {
            $endofmonth = Carbon::now()->endOfMonth()->toDateString();
            $today = Carbon::now()->toDateString();

            if ($today != $endofmonth)
            {
                return response()->json([
                    'error' => true,
                    'message' => 'Wait till the end of the month to make the draw'
                ], 400);
            }

            // get the current winner randomly
            $getAllSubscriptionInThisMonth = GreenCard::where('open_to_pool', true)
                ->whereMonth('created_at', Carbon::now()->format('m'))->get('audience_id')->random();
            
            $setWinnerTo_Off_Pool = GreenCard::where('audience_id', $getAllSubscriptionInThisMonth['audience_id'])->first();
            $setWinnerTo_Off_Pool->open_to_pool = false; //only the winner gets to be out of the pool
            $setWinnerTo_Off_Pool->save();

            $remainingVouchers = GreenCard::where('open_to_pool', true)->get();
            $getsubscriptionplan = CampaignSubscriptionPlan::where('campaign_id', $campaign_id)->first();
            foreach ($remainingVouchers as $remaining)
            {
                GreenCard::create([
                    'audience_id' => $remaining->audience_id,
                    'campaign_id' => $campaign_id,
                    'campaign_subscription_plan_id' => $getsubscriptionplan->id,
                    'ticket_number' => uniqid(),
                    'date' => Carbon::tomorrow()->format('Y-m-d')
                ]);
            }

        } catch (\Exception $exception){
            //report($exception);
            return response()->json(['status' => false, 'message' => $exception->getMessage()], 500);
        }
        return response()->json(['error' => false, 'message' => 'Draw Completed'], 201);

    }

    public function winnerList()
    {
        /*
        try {
            $winnerLists = GreenCard::where('open_to_pool', false)->pluck(['audience_id'])->toArray();
            if (empty($winnerLists))
            {
                return response()->json([
                    'data' => []
                ], 200);
            }

            $audiencesUsers = (new GetBatchAudience(['user_id' => $winnerLists]))->run();
            
            // Emeka Assumption
            // $audienceUsers = [];

            // foreach($winnerLists as $audience_id) {
            //    $audience = Audience::find($audience_id);
            //    if(isset($audience)) 
            //    {
            //     array_push($audienceUsers, $audience);
            //    }
            // }

        } catch (\Exception $exception){
            //report($exception);
            return response()->json(['status' => false, 'message' => $exception->getMessage()], 500);
        }
        return response()->json([$audiencesUsers], 200); 
        */ 
    }

    public function getsubscriptionPrice($campaign_id)
    {
        try {
            $subscriptionPrice = CampaignSubscriptionPlan::where('campaign_id', $campaign_id)->first()->price;
        
        }catch (\Exception $exception){
            //report($exception);
            return response()->json(['status' => false, 'message' => $exception->getMessage()], 500);
        }
        return response()->json(['data' => $subscriptionPrice], 200);
    }
}
