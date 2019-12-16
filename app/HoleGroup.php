<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HoleGroup extends Model
{    
    protected static function boot() {
        parent::boot();
        \Log::info('here');
        static::deleting(function($holeGroup) {
             $holeGroup->holes()->delete();
        });
    }
    protected $fillable = [
        'course_id', 
        'group_name',
        'teebox',
        'number_of_holes'
    ];

    public function course() {
    	return $this->belongsTo('App\Course');
    }

    public function holes() {
    	return $this->hasMany('App\Hole');
    }
}
