<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends BaseModel
{
    protected $table = 'games';

    public function gameObjects() {
        return $this->hasMany('App\Models\GameObject', 'game_id');
    }
}
