<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'uuid', 
        'first_name', 
        'last_name', 
        'email', 
        'password',
        'nick_name',
        'age',
        'gender',
        'locality',
        'administrative_area_level_1',
        'administrative_area_level_2',
        'country'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
