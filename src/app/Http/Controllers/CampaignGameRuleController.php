<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\CampaignGameRule;
use Illuminate\Http\Request;

class CampaignGameRuleController extends Controller
{
    //
    public function indexCampaignGameRule() {

        try {
            // get all campaign game rules
            $cgr = CampaignGameRule::all();
        
        } catch (\Throwable $throwable) {
            return response()->json([
                "error" => "true",
                "message" => $throwable->getMessage()
            ]);
        }

        return response()->json([
            "error" => "false",
            "campaignGameRules" => $cgr
        ]);
    }


    public function storeCampaignGameRuleController(Request $request) {
        $request->validate([
            'campaign_id' => 'required|exists:campaigns,id',
            'leaderboard_num_winners' => 'required|integer'
        ]);

        try {
            // get all campaign game rules
            $cgr = CampaignGameRule::create([
                "campaign_id" => $request->campaign_id,
                "leaderboard_num_winners" => $request->leaderboard_num_winners
            ]);
        
        } catch (\Throwable $throwable) {
            return response()->json([
                "error" => "true",
                "message" => $throwable->getMessage()
            ]);
        }
        return response()->json([
            "error" => "false",
            "campaignGameRule" => $cgr
        ]);
    }

    /**
     * show
     * 
     * @param mixed $campaign_id
     * @param mixed $subscription_id
     * @return Illuminate\Http\Response
    */

    public function show($campaign_id, $rule_id)
    {
        try {
            $rule = CampaignGameRule::find($rule_id);
        
        } catch (\Throwable $throwable) {
            return response()->json([
                "error" => "true",
                "message" => $throwable->getMessage()
            ]);
        }

        return response()->json(['error' => false, 'message' => 'Campaign game rules', 'data' =>  $rule], 200);

    }
}
