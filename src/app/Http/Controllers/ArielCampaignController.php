<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ArielInfluencer;
use App\Models\ArielShoppingSite;
use App\Http\Controllers\Controller;
use App\Models\ArielInfluencerActivity;
use Carbon\Carbon;


class ArielCampaignController extends Controller
{
    /**
     * getShoppingSites
     * 
     * @return void
     */
    public function getShoppingSites()
    {
        try {
            $sites = ArielShoppingSite::get();
        
        } catch (\Throwable $th) {
            report($th);
            return response()->json([
                'error' => true,
                'message' => 'unable to get ariel shopping sites'
            ], 500);
        }

        return response()->json(['data' => $sites], 200);
    }
    
    /**
     * redeemReferralCode
     * 
     * @param mixed $code
     * @return void
     */
    public function redeemReferralCode($code)
    {
        try {
            $code = Str::replace('%20', ' ', $code);
            $influencer = ArielInfluencer::where('code', strtolower($code))->firstOrFail();
        } catch (\Throwable $th) {
            report($th);
            return response()->json(['error' => true, 'mesage' => 'Invalid referral code'], 400);
        }
        return response()->json($influencer);
    }

    /**
     * registerInfluencingacitivities
     * 
     * @param mixed $request
     * @return void
     */
    public function registerInfluencingActivities(Request $request)
    {
        $validated = $this->validate($request, [
            'influencer_id' => 'required|exists:ariel_influencers,id',
            'shopping_site_id' => 'required|exists:ariel_shopping_sites,id'
        ]);

        try {
            // creates an ArielInfluencerActivity
            $activity = ArielInfluencerActivity::create([
                'ariel_influencer_id' => $validated['influencer_id'],
                'ariel_shopping_site_id' => $validated['shopping_site_id']
            ]);
        } catch (\Throwable $th) {
            report($th);
            return response()->json(['error' => true, 'message' => 'Unable to register influencing activity'], 500);
        }

        return response()->json(['message' => 'Influencing activity registered']);
    }

    public function analytics(Request $request)
    {
        $validated = $this->validate($request, [
            'range' => 'nullable|integer'
        ]);

        try {
            $data = [];

            $data['shopping_sites'] = ArielShoppingSite::withCount(['influencerActivities' => function ($query) use ($validated) {
                $query->when(!is_null($validated['range']), function ($query) use ($validated) {
                    $query->whereDate('created_at', '>=', Carbon::today()->subDays($validated['range']));
                });
            }])->get();

            $data['influencers'] = ArielInfluencer::withCount(['influencerActivities' => function ($query) use ($validated) {
                $query->when(!is_null($validated['range']), function ($query) use ($validated) {
                    $query->whereDate('created_at', '>=', Carbon::today()->subDays($validated['range']));
                });
            }])->get();

            $data['unique_referral_codes_inputted'] = ArielInfluencerActivity::when(!is_null($validated['range']), function ($query) use ($validated) {
                $query->whereDate('created_at', '>=', Carbon::today()->subDays($validated['range']));
            })->count();
        
        
        } catch (\Throwable $th) {
            report($th);
            return response()->json(["message" => "unable to fetch campaign analytics"], 500);
        }

        return response()->json(['data' => $data]);
    }


    // Emeka
    public function storeArielInfluencer(Request $request) 
    {
        $validated = $request->validate([
            "full_name" => 'required|string',
            "code" => 'required|string'
        ]);

        try {
           $influencer = ArielInfluencer::create([
                "full_name" => $validated["full_name"],
                "code" => $validated["code"]
            ]);

        } catch (\Throwable $th) {
            report($th);
            return response()->json(["message" => "unable to create influencer", "error" => $th->getMessage()], 500);
        }

        
        return response()->json([
            "error" => false,
            "message" => "created influencer successfully",
            "influencer" => $influencer
        ]);
    }

    public function storeShoppingSite(Request $request)
    {
        $validated = $request->validate([
            "name" => 'required|string',
            "icon" => 'required|string',
            "url" => 'required|string'
        ]);

        try {
           $shoppingSite = ArielShoppingSite::create([
                "name" => $validated["name"],
                "icon" => $validated["icon"],
                "url" => $validated["url"]
            ]);

        } catch (\Throwable $th) {
            report($th);
            return response()->json(["message" => "unable to create shopping site"], 500);
        }

        
        return response()->json([
            "error" => false,
            "message" => "created influencer successfully",
            "influencer" => $shoppingSite
        ]);
    }
}
