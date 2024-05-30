<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CampaignGame;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CampaignGameController extends Controller
{
    //


    public function index($campaign_id)
    {
        try {
            // Retrieve the campaign games for the specified campaign_id
            $games = CampaignGame::where('campaign_id', $campaign_id)->get();
    
            // Check if any games were found
            if ($games->isEmpty()) {
                return response()->json(['error' => true, 'message' => 'No games found for the specified campaign'], 404);
            }
    
            // If games were found, return them in the response
            return response()->json(['error' => false, 'message' => 'Campaign Games', 'data' =>  $games], 200);
    
        } catch (\Throwable $th) {
            // Report any exceptions
            report($th);
            // Return an error response
            return response()->json(['error' => true, 'message' => 'Something went wrong'], 500);
        }
    }
    


    public function store(Request $request, $campaign_id)
    {
        $validated = $this->validate($request, [
            'games' => 'required|array',
            'games.*.id' => 'required|uuid'
        ]);

        try {
            $campaign_games = DB::transaction(function () use ($validated, $campaign_id) {
                $temp = [];

                foreach ($validated['games'] as $game) {
                    $campaign_game = CampaignGame::firstOrCreate([
                        'campaign_id' => $campaign_id,
                        'game_id' => $game['id']
                    ], $game);
                    array_push($temp, $campaign_game);
                }
                return $temp;
            });
        } catch (\Throwable $th) {
            Report($th);
            return response()->json(['error' => true, 'message' => 'something went wrong'], 500);
        }
        return response()->json(['error' => false, 'message' => 'Campaign Games', 'data' => $campaign_games], 201);
    }


    public function show($campaign_id, $game_id)
    {
        try {
            $game = CampaignGame::where('game_id', $game_id)->where('campaign_id', $campaign_id)->first();

            if (!$game) {
                return response()->json(['error' => true, 'message' => 'Campaign game not found'], 404);
            }

        } catch (\Throwable $th) {
            report($th);
            return response()->json(['error' => true, 'message' => 'Something went wrong'], 500);
        }
        return response()->json(['error' => false, 'message' => 'Campaign Game', 'data' =>  $game], 200);
    }


}
