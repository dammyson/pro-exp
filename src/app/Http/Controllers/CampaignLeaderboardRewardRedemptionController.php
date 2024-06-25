<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CampaignLeaderboardRewardRedemption;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CampaignLeaderboardRewardRedemptionController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * index
     *
     * @param  mixed $campaign_id
     * @return \Illuminate\Http\Response
    */

    public function index(Request $request, $campaign_id, $audience_id)
    {
        $validated = $this->validate($request, [
            'range' => 'nullable|integer'
        ]);

        try {
            $rewards = CampaignLeaderboardRewardRedemption::with(['campaignLeaderboardReward'])
                ->where('campaign_id', $campaign_id)
                ->where('audience_id', $audience_id)
                ->when(!is_null($validated['range']), function ($query) use ($validated) {
                    $query->whereDate('created_at', '>=', Carbon::today()->subDays($validated['range']));
                })->get();

        } catch (\Throwable $th) {
            report($th);
            return response()->json(['error' => true, 'mesage' => 'something went wrong'], 500);
        }

        return response()->json(['error' => false, 'reward' => $rewards], 500);

        // return RedemptionResource::collection($rewards);

    }

    public function todayWinning($campaign_id, $audience_id) 
    {
        try {
            $reward = CampaignLeaderboardRewardRedemption::with(['campaignLeaderboardReward'])
                ->where('campaign_id', $campaign_id)
                ->where('audience_id', $audience_id)
                ->whereDate('created_at', Carbon::today())
                ->first();
            
            if (is_null($reward)) {
                return response()->json(["message" => "no winnings was found"], 200);
            }

        } catch (\Throwable $th) {
            report($th);
            return response()->json(['error' => true, 'mesage' => 'something went wrong'], 500);
        }

        return response()->json(['error' => true, 'reward' => $reward], 500);

    }
}
