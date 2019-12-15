<?php

namespace App\Http\Controllers;

use Log;
use App\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index()
    {
        return view('course.index');
    }

    public function create()
    {
        return view('course.create');
    }

    public function store(Request $request)
    {   
        Log::info($request);
        // return response()->json(['success' => 'Course successfully created.'], 200);
    }

    public function show(Course $course)
    {
        //
    }

    public function edit(Course $course)
    {
        //
    }

    public function update(Request $request, Course $course)
    {
        //
    }

    public function destroy(Course $course)
    {
        //
    }
}
