<?php

namespace App;

use App\Favorite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{   
    protected static function boot() {
        parent::boot();
    
        static::deleting(function($course) { 
            foreach($course->holeGroups as $holeGroup) {
              $holeGroup->delete();
            }
        });
    }

    protected $fillable = [
        'course_name', 
        'course_address',
        'course_phone',
        'street_number',
        'featured_image',
        'route',
        'locality',
        'administrative_area_level_1',
        'country',
        'postal_code',
        'course_lat',
        'course_lng'
    ];

    public function holeGroups() {
    	return $this->hasMany('App\HoleGroup');
    }

    public function favorited() {
        return (bool) Favorite::where('user_id', Auth::id())
                            ->where('course_id', $this->id)
                            ->first();
    }
}
