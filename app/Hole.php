<?php

namespace App;

use App\HoleGroup;

use Illuminate\Database\Eloquent\Model;

class Hole extends Model
{
    protected $fillable = [
        'hole_group_id',
        'hole_number',
        'hole_length',
        'hole_par'
    ];

    public function holeGroup() {
    	return HoleGroup::find($this->hole_group_id);
    }
}
