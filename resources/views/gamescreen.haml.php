@extends('layouts.app')

@section('title', 'Game 88')

@section('content')

.title Build phase

%script{type: "text/javascript", src: "js/game.js"}

.weapons.col-xs-3
  %ul
    %li.weapon.time-bomb.selected{"data-id" => "1"}
      (1) Time bomb
      .ammo
    %li.weapon.flame{"data-id" => "2"}
      (2) Flame
      .ammo
    %li.weapon.target{"data-id" => "3"}
      (3) Cactus
      .ammo

.grid.col-xs-6
  - for($i = 0; $i < 6; $i++)
    .row
    - for($j = 0; $j < 6; $j++)
      .grid-square.col-xs-2{"data-y" => $i, "data-x" => $j}

.info.col-xs-3
  %ul
    %li.clock (0 seconds / 20)
    //Mozna budicek nebo castejsi update....?

@stop