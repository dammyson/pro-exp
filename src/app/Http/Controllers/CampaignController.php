<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    //

    public function activeCampaigns()
    {
        try {
            $campaigns = Campaign::where('status', 'ACTIVE')->orderBy('created_at', 'desc')->get();

            if ($campaigns->isEmpty()) {
                return response()->json(['message' => 'No active campaigns found.'], 404);
            }

        } catch (\Throwable $th) {
            report($th);
            return response()->json(['error' => true, 'message' => 'Something went wrong'], 500);
        }
        return response()->json(['message' => 'Active campaigns found.', 'campaigns' => $campaigns], 200);
    }


    public function fetchCampaigns($title)
    {
        try {
            $fetchedCampaign = Campaign::where('title', $title)->first();
    
            if (!$fetchedCampaign) {
                return response()->json(['error' => true, 'message' => 'Campaign not found'], 404);
            }
    
            return response()->json(['error' => false, 'data' => $fetchedCampaign->id], 200);
    
        } catch (\Exception $exception) {
            return response()->json(['error' => true, 'message' => $exception->getMessage()], 500);
        }
    }
    


    public function storeInformation(Request $request)
    {
        $validated = $this->validate($request, [
            'type' => 'required|string|min:3',
            'title' => 'required|string|min:3',
            'client_id' => 'required',
            'brand_id' => 'required',
            'company_id' => 'required',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'daily_start' => 'sometimes|required|date_format:H:i:s',
            'daily_stop' => 'sometimes|required|date_format:H:i:s'
        ]);

        try {
            $campaign = Campaign::firstOrCreate([
                'title' => $validated['title'],
                'client_id' => $validated['client_id'],
                'brand_id' => $validated['brand_id'],
                'company_id' => $validated['company_id'],
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date']
            ], $validated);

        } catch (\Throwable $th) {
            dd($th);
            report($th);
            return response()->json(['error' => true, 'mesage' => $th->getMessage()], 500);
        }
        return response()->json(['error' => false, 'message' => 'Campaigns', 'data' =>  $campaign], 201);
    }


    public function show($campaign_id)
    {
        try {
            $campaign = Campaign::find($campaign_id);
        } catch (\Throwable $th) {
            report($th);
            return response()->json(['error' => true, 'mesage' => 'something went wrong'], 500);
        }
        return response()->json(['error' => false, 'message' => 'Campaign information', 'data' =>  $campaign], 200);
    }
}
