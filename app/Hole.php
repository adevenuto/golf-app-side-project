<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hole extends Model
{
    protected $fillable = [
        'hole_group_id',
        'hole_number',
        'hole_length'
    ];

    public function holeGroups() {
    	return $this->belongsTo('App\HoleGroup');
    }
}
