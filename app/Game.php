<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        'uuid',
        'user_id',
        'status',
        'game_data'
    ];
}
