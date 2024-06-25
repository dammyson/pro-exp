<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CampaignReferral;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class CampaignReferralController extends Controller
{

    public function index($campaign_id) {
        $referrals = CampaignReferral::where('campaign_id', $campaign_id)->get();
    
        return response()->json([
            'error' => false,
            'message' => 'List referrals for campaign',
            'data' => $referrals
        ], 200);
    }

    public function create(Request $request, $campaign_id) {
        $validated = $this->validate($request, [
            'referrer_id' => 'required|string',
        ]);

        try {
            // This means you cant have the same referrer id more than once for a
            // campaign
            $referral = CampaignReferral::firstOrCreate([
                    'campaign_id' => $campaign_id,
                    'referrer_id' => $validated['referrer_id']
                ],[
                    'code' => Str::uuid()
                ]);

        } catch (\Throwable $th) {
            //Report($th);
            return response()->json(['error' => true, 'message' => 'something went wrong'], 500);
        }
        return response()->json(['error' => false, 'message' => 'Referral code generated', 'data' => $referral], 201);
    }

    public function show($campaign_id, $id)
    {
        try {
            $referral = CampaignReferral::findOrFail($id);
        } catch (\Throwable $th) {
            //report($th);
            return response()->json(['error' => true, 'message' => 'something went wrong'], 500);
        }
        return response()->json(['error' => false, 'message' => 'Campaign referral code retrieved by ID', 'data' => $referral], 200);
    }

    public function showByReferrer($campaign_id, $referrer_id) 
    {
        try {
            // from our implementation here it means and audiences can only have one referrer_id
            // to a campaign 
            $referral = CampaignReferral::where('campaign_id', $campaign_id)->where('referrer_id', $referrer_id)->firstOrFail();
        
        } catch (\Throwable $th) {
            //report($th);
            return response()->json(['error' => true, 'message' => 'something went wrong'], 500);
        }

        return response()->json(['error' => false, 'message' => 'Campaign referral code retrieved by ID', 'data' => $referral], 200);
    }

    public function referralCountForLeaderboard(Request $request, $campaign_id)
    {
        try {
            // this will return all the referrer_id and the total count of all 
            // CampaignReferralActivity count that match the query (it is a one whole number)

            $referrals = CampaignReferral::whereHas('referents', function ($query) {
                //find campaignReferralActivity where is_activity is true
                $query->where('is_activated', true);
                // $query->where('is_activation_point_redeemed', false);
                $query->whereDate('updated_at', date('Y-m-d'));
            })
            ->withCount(['referents' => function ($query) {
                // count the referents where is_activated is true
                $query->where('is_activated', true);
                // $query->where('is_activation_point_redeemed', false);
                $query->whereDate('updated_at', date('Y-m-d'));

            }])
            ->where('campaign_id', $campaign_id)->get()
            ->pluck('referents_count', 'referrer_id')->all();

        } catch (\Throwable $th) {
            //report($th);
            return response()->json(['error' => true, 'message' => 'something went wrong'], 500);
        }

        return response()->json(['data' => $referrals], 200);
    }

    // we may need to put a method to called generateReferrerId this should combine the
    // the audience id and the campaignId to generate a unique code for the campaign

    public function generateReferrerId (Request $request, $campaign_id) {
        try {
            $audienceId = request()->user('audience')->id;
            $referrerId = $audienceId . $campaign_id;

        }  catch (\Throwable $th) {
            //report($th);
            return response()->json(['error' => true, 'message' => 'something went wrong'], 500);
        }

        return response()->json([
            'error' => 'false',
            'referrerId' =>  $referrerId
        ]);
    }
}
