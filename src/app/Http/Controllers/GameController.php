<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GameController extends Controller
{
    //
    public function index() {

        try {
            $games = Game::get();

            if ($games->isEmpty()) {
                return response()->json(['message' => 'No games found.'], 404);
            }
            

        } catch(\Throwable $throwable) {
            
            report($throwable);
            response()->json([
                "error" => "true",
                "message" => $throwable->getMessage()
            ], 500);
        }

        return response()->json(["error" => "false", ...$games], 200);

    }

    // custom request handler will be made in future
    public function storeGame(Request $request) {
        $request->validate([
            'name' => 'required'
        ]);

        try {
            $game = Game::create([
                'name'=> $request->name
            ]);

            // dd($game);

        } catch (\Throwable $throwable) {

            report($throwable);
            return response()->json([
                'error' => 'true',
                'message' => $throwable->getMessage()
            ], 500);
        }

        return response()->json(["error" => "false", $game], 200);
    }

    public function showGame($gameId) {
        try {
           $game = Game::find($gameId);

           if (!$game) {
            return response()->json(['error' => 'false', 'message' => 'no game found'], 404);
           }
        
        } catch (\Throwable $throwable) {

            report($throwable);
            return response()->json([
                'error' => 'true',
                'message' => $throwable->getMessage()
            ], 500);
        }

        return response()->json(["error" => "false", $game], 200);
    }

    public function updateGame(Request $request, $game_id) {
        $validated = $request->validate([
            'name' => 'required'
        ]);


        try {
            $game = Game::find($game_id);

            if (!$game) {
                return response()->json(['error' => 'false', 'message' => 'Game not found'], 404);
            }

            $game->name = $validated['name'];
            $game->save();

        } catch (\Throwable $throwable) {
            report($throwable);
            return response()->json([
                'error' => 'true',
                'message' => $throwable->getMessage()
            ], 500);

        }

        return response()->json(["error" => "false", 'message' => 'Game updated successfully', $game], 200);
        
    }
}
