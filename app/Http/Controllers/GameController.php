<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use Log;

class GameController extends Controller
{
    public function create()
    {   
        return view('game.create');
    }

    public function store(Request $request)
    {
        Log::info($request);
        return redirect('game/4324');
    }

    public function show($id)
    {
        return view('game.show');
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
