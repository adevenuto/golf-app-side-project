<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HoleGroup extends Model
{    
    protected static function boot() {
        parent::boot();
    
        static::deleting(function($holeGroup) { 
            foreach($holeGroup->holes as $hole){
              $hole->delete();
            }
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
