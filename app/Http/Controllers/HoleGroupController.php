<?php

namespace App\Http\Controllers;

use Log;
use App\Hole;
use App\HoleGroup;
use Illuminate\Http\Request;

class HoleGroupController extends Controller
{
    public function __construct(HoleGroup $holeGroup, Hole $hole) 
    {
        $this->holeGroup = $holeGroup;
        $this->hole = $hole;
    }

    public function edit($id)
    {
        $holeGroup = HoleGroup::find($id);
        $holeGroupHoles = $holeGroup->holes;
        return response()->json([
            'holeGroup' => $holeGroup, 
            'holeGroupHoles' => $holeGroupHoles, 
        ], 200);
    }

    public function store(Request $request)
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
    
    public function update(Request $request)
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
