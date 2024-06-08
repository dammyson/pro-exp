<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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
            'campaign_id' => 'required|exists:campaigns,id'
        ]);

        try {
            // get all campaign game rules
            $cgr = CampaignGameRule::create([
                "campaign_id" => $request->campaign_id
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
}
