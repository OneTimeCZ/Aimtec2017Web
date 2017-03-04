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
        $this->middleware('auth');
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
        foreach ($request->all()['weapons'] as $weapon) {
            var_dump($weapon);
            //TODO create models
        }
    }

    public function leaderboard() {
        return view('leaderboard');
    }

    public function howto() {
        return view('howto');
    }

    public function plan()
    {
        return response()->json([
            ['x' => 2, 'y' => 2, 'type' => 'bomb', 'time' => 12],
            ['x' => 1, 'y' => 3, 'type' => 'box', 'time' => 52],
            ['x' => 3, 'y' => 2, 'type' => 'box', 'time' => 63],
            ['x' => 5, 'y' => 2, 'type' => 'strike', 'time' => 90],
            ['x' => 1, 'y' => 1, 'type' => 'bomb', 'time' => 1390],
            ['x' => 0, 'y' => 2, 'type' => 'bomb', 'time' => 7892]
        ]);
    }
}
