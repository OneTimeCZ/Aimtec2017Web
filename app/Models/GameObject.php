<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameObject extends BaseModel
{
    protected $table = 'game_objects';

    public function game() {
        return $this->belongsTo('App\Models\Game');
    }
}
