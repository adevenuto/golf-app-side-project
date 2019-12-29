<?php

namespace App\Http\Controllers;

use Log;
use App\Hole;
use App\Course;
use App\HoleGroup;
use App\Traits\ImageHelpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{   
    use ImageHelpers;

    public function __construct(Course $course, HoleGroup $holeGroup, Hole $hole) 
    {
        $this->course = $course;
        $this->holeGroup = $holeGroup;
        $this->hole = $hole;
    }

    public function search(Request $request)
    {   
        if (isset($request->term)) {
            $courses = Course::where('course_name', 'like','%'.$request->term.'%')->get();
            return response()->json(['courses' => $courses], 200);
        }
        return response()->json(['failed' => 'no results'], 400);
    }

    public function index()
    {   $courses = $this->course->all();
        return view('course.index')->with('courses', $courses);
    }

    public function create()
    {
        return view('course.create');
    }

    public function store(Request $request)
    {   
        try {
            $payload = $request->all();
            $course = $this->course->create($payload);

            $course_id = $course->id;
            $payload['course_id'] = $course_id;
            $holeGroup = $this->holeGroup->create($payload);
            $holeGroupId = $holeGroup->id;

            $holes = array_filter($payload, function ($key) {
                return strpos($key, 'hole_') === 0;
            }, ARRAY_FILTER_USE_KEY);

            $holepars = array_filter($payload, function ($key) {
                return strpos($key, 'holepar_') === 0;
            }, ARRAY_FILTER_USE_KEY);
            $holepars_values = array_values($holepars);

            $holesCount = 0;
            foreach ($holes as $key => $hole_length) {
                $hole_num = substr($key, strpos($key, "_") + 1);
                $hole_par = $holepars_values[$holesCount];
                $this->hole->create([
                    'hole_group_id' => $holeGroupId, 
                    'hole_number' => $hole_num, 
                    'hole_length' => $hole_length,
                    'hole_par' => $hole_par
                ]);
                $holesCount ++;
            }

            if($request->hasFile('course_image')) {
                $file = $request->file('course_image');
                $fileComponents = $this->getFileComponents($file);
                $img_resized = $this->resizeImage($file, 500, 500);
            
                $filenameToStore = $fileComponents['filename'].'_'.time().'.'.$fileComponents['extension'];
                $folder = 'courses/'.$course_id.'/';
                
                Storage::disk('s3')->put($folder.$filenameToStore, $img_resized, 'public');
                $course['featured_image'] = $folder.$filenameToStore;
                $course->save();
            }

        } catch (\Exception $e) {
            return response()->json(['failed' => $e->getMessage()], 400);
        }
        return response()->json(['success' => 'Course successfully created.'], 200);
    }

    public function show(Course $course)
    {
        //
    }

    public function edit($id)
    {   
        $course = Course::find($id);
        $holegroups = $course->holegroups;
        return view('course.edit')->with([
            'course' => $course, 
            'holegroups' => $holegroups
        ]);
    }

    public function update(Request $request)
    {   
        try {
            $course_id = $request->course_id;
            $course = Course::find($course_id);
            $course->update($request->all());

            if($request->hasFile('course_image')) {
                $file = $request->file('course_image');
                $fileComponents = $this->getFileComponents($file);
                $img_resized = $this->resizeImage($file, 500, 500);
            
                $filenameToStore = $fileComponents['filename'].'_'.time().'.'.$fileComponents['extension'];
                $folder = 'courses/'.$course_id.'/';
                
                Storage::disk('s3')->put($folder.$filenameToStore, $img_resized, 'public');
                $course['featured_image'] = $folder.$filenameToStore;
                $course->save();
            }
        } catch (\Exception $e) {
            return response()->json(['failed' => $e->getMessage()], 400);
        }
        return response()->json(['success' => 'Course successfully updated.'], 200);
    }

    public function destroy(Course $course)
    {
        //
    }












    public function storeHoleGroup(Request $request)
    {
        try {
            $payload = $request->all();
            $holeGroup = $this->holeGroup->create($payload);
            $holeGroupId = $holeGroup->id;

            $holes = array_filter($payload, function ($key) {
                return strpos($key, 'hole_') === 0;
            }, ARRAY_FILTER_USE_KEY);

            $holepars = array_filter($payload, function ($key) {
                return strpos($key, 'holepar_') === 0;
            }, ARRAY_FILTER_USE_KEY);
            $holepars_values = array_values($holepars);

            $holesCount = 0;
            foreach ($holes as $key => $hole_length) {
                $hole_num = substr($key, strpos($key, "_") + 1);
                $hole_par = $holepars_values[$holesCount];
                $this->hole->create([
                    'hole_group_id' => $holeGroupId, 
                    'hole_number' => $hole_num, 
                    'hole_length' => $hole_length,
                    'hole_par' => $hole_par
                ]);
                $holesCount ++;
            }
        } catch (\Exception $e) {
            return response()->json(['failed' => $e->getMessage()], 400);
        }
        return response()->json(['holegroup' => $holeGroup], 200);
    }
    public function editHoleGroup($id)
    {
        $holeGroup = HoleGroup::find($id);
        $holeGroupHoles = $holeGroup->holes;
        return response()->json([
            'holeGroup' => $holeGroup, 
            'holeGroupHoles' => $holeGroupHoles, 
        ], 200);
    }
    public function updateHoleGroup(Request $request)
    {   
        try {
            $holegroup_id = $request->holegroup_id;
            $holeGroup = HoleGroup::find($holegroup_id);
            $holeGroup->update($request->all());


            $holeIds = $request->hole_id;
            $holePars = $request->hole_par;
            $holeLengths = $request->hole_length;
            $holes = array_map(function ($hole_id, $hole_par, $hole_length) {
                return array_combine(
                ['hole_id', 'hole_par', 'hole_length'],
                [$hole_id, $hole_par, $hole_length]
                );
            }, $holeIds, $holePars, $holeLengths);
            foreach($holes as $_hole) {
                $hole = Hole::find($_hole['hole_id']);
                $hole->hole_par = $_hole['hole_par'];
                $hole->hole_length = $_hole['hole_length'];              
                $hole->save();
            }    
        } catch (\Exception $e) {
            return response()->json(['failed' => $e->getMessage()], 400);
        }
        return response()->json(['Success' => 'Holegroup was updated'], 200);
    }
}
