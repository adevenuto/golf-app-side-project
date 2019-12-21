<?php

namespace App\Http\Controllers;

use App\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function favoriteCourse($id)
    {   
        $course = Course::find($id);
        Auth::user()->favorites()->attach($course->id);
    }

    public function unFavoriteCourse($id)
    {   
        $course = Course::find($id);
        Auth::user()->favorites()->detach($course->id);
    }
}
