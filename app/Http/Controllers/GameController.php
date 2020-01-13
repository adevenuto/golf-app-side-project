<?php

namespace App\Http\Controllers;

use Log;
use App\Course;
use App\Game;
use Webpatser\Uuid\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    public function create()
    {   
        return view('game.create');
    }

    public function store(Request $request)
    {   
        try {
            $game = new Game;
            $game->user_id = Auth::user()->id;
            $game->uuid = Uuid::generate()->string;
            $game->status = 'in progress';
            $gameData = [
                'course' => $request->course,
                'holegroups' => $request->holeGroups
            ];
            $gameData_json = json_encode($gameData);
            $game->game_data = $gameData_json;
            $game->save();

            $url = '/game/'.$game->uuid;
            return response()->json(['url' => $url], 200);
        } catch (\Exception $e) {
            return response()->json(['failed' => $e->getMessage()], 400);
        }
    }

    public function show($uuid)
    {   
        try {
            $game = Game::where('uuid', $uuid)->first();
            // Build 404 page
            if (!$game) abort(404);
            $game_data_decoded = json_decode($game->game_data, true);
            $course = json_encode($game_data_decoded['course']);
            $holegroups = json_encode($game_data_decoded['holegroups']);
            return view('game.show')->with(['course' => $course, 'holegroups' => $holegroups]);
        } catch (\Exception $e) {
            return response()->json(['failed' => $e->getMessage()], 404);
        }
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
