<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GameController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function lobbyShow()
    {
        return view('lobby');
    }

    public function gameShow()
    {
        return view('gamescreen');
    }

    public function map(Request $request)
    {
        $game = $this->getGame();
        $game->gameObjects()->delete();
        foreach ($request->all()['weapons'] as $weapon) {
            $go = new \App\Models\GameObject();
            $go->pos_x = $weapon['x'];
            $go->pos_y = $weapon['y'];
            $go->time = $weapon['time'];
            if ($weapon['type'] == 1)
                $go->name = 'bomb';
            if ($weapon['type'] == 2)
                $go->name = 'fire';
            if ($weapon['type'] == 3)
                $go->name = 'box';
            $game->gameObjects()->save($go);
            //TODO create models
        }
    }

    public function leaderboard()
    {
        return view('leaderboard');
    }

    public function howto()
    {
        return view('howto');
    }

    public function plan()
    {
        $game = $this->getGame();
        $events = [];

        foreach ($game->gameObjects as $object) {
            $events []= [
                'x' => $object->pos_x,
                'y' => $object->pos_y,
                'time' => $object->time,
                'name' => $object->name
            ];
        }
        return response()->json($events);
    }

    private function getGame()
    {
        $game = \App\Models\Game::first();

        if (!$game) {
            $game = new \App\Models\Game();
            $game->name = "generic game";
            $game->save();
        }

        return $game;
    }
}
