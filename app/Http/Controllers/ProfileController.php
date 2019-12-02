<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {   
        $user = Auth::user();
        return view('profile.index')->with('user', $user);
    }

    public function store(Request $request)
    {   
        try {
            $user = Auth::user(); 
            $user->nick_name = $request['nick_name'];
            $user->age = $request['age']; 
            $user->gender = $request['gender'];

            if(isset($request['locality'])) $user->locality = $request['locality']; 
            if(isset($request['administrative_area_level_1'])) $user->administrative_area_level_1 = $request['administrative_area_level_1']; 
            if(isset($request['administrative_area_level_2'])) $user->administrative_area_level_2 = $request['administrative_area_level_2']; 
            if(isset($request['country'])) $user->country = $request['country'];

            $user->save();

            return response()->json(['user' => $user], 200);
            
        } catch (\Exception $e) {
            return response()->json(['failed' => $e->getMessage()], 400);
        }
        
    }


    public function authUser() {
        $auth_user = Auth::user();
        return response()->json(['user' => $auth_user], 200);
    }
}
