<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
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
}
