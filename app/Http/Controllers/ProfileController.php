<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ImageHelpers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{   
    use ImageHelpers;

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
            
            if($request->hasFile('profile_image')) {

                $file = $request->file('profile_image');
                $fileComponents = $this->getFileComponents($file);
                $img_resized = $this->resizeImage($file, 250, 250);
            
                $filenameToStore = $fileComponents['filename'].'_'.time().'.'.$fileComponents['extension'];
                $folder = 'profiles/'.$user->id.'/';

                if(!Storage::exists($folder)) {
                    Storage::makeDirectory($folder);
                }

                Storage::disk('s3')->put($folder.$filenameToStore, $img_resized, 'public');

                $user->image_path = $folder.$filenameToStore;
                $user->save();
            }
            return response()->json(['user'=>$user], 200);
        } catch (\Exception $e) {
            return response()->json(['failed' => $e->getMessage()], 400);
        }
        
    }


    public function authUser() {
        $auth_user = Auth::user();
        return response()->json(['user' => $auth_user], 200);
    }
}
