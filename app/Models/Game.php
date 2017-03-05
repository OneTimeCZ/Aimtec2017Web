<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $table = 'games';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany relation
     */
    public function gameObjects()
    {
        return $this->hasMany(GameObject::class, 'game_id');
    }
}
