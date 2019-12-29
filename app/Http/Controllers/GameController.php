<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;

class GameController extends Controller
{

    public function create()
    {   
        return view('game.create');
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
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
