<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CampaignGamePrize;
use App\Http\Controllers\Controller;
use App\Models\Campaign;

class CampaignGamePrizeController extends Controller
{
    //
    public function index()
    {
        try {
            $gamePrize = CampaignGamePrize::all();
        } catch (\Throwable $th) {
            report($th);
            return response()->json(['error' => true, 'message' => 'cannot fetch'], 500);
        }

        return response()->json(['error' => false, 'message' => 'Game Prize List', 'data' => $gamePrize]);

    }

    public function store(Request $request)
    {
        $validated = $this->validate($request, [
            'name' => 'required|string',
            'amount' => 'required|numeric'
        ]);

        try {
            // if name doesn't exist in the CampaignGamePrize DB then create one and add the amount else just update the amount
            $check = CampaignGamePrize::where('name', $validated['name'])->first();

            if ($check == null) {
                $storeGamePrize = CampaignGamePrize::updateOrCreate(['name' => $validated['name'], 'amount' => $validated['amount']]);
            } else {
                $check->update(['amount' => $validated['amount']]);
                $storeGamePrize = CampaignGamePrize::find($check->id);
            }
        } catch (\Throwable $th) {
            report($th);
            return response()->json(['error' => true, 'message' => 'cannot save game prize'], 500);
        }

        return response()->json(['error' => false, 'message' => 'Game Prize Saved', 'data' => $storeGamePrize]);
    }
}
