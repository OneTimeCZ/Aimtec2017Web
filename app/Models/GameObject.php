<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameObject extends Model
{
    protected $table = 'game_objects';

    public function game()
    {
        return $this->belongsTo(Game::class, 'game_id');
    }
}
