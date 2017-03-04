@extends('layouts.app')

@section('title', 'Game 88')

@section('content')

.title Build phase

.weapons.col-xs-3
  %ul
    %li (1) Time bomb
    %li.selected (2) Flame
    %li (3) Target

.grid.col-xs-6
  - for($i = 0; $i < 6; $i++)
    .row
    - for($j = 0; $j < 6; $j++)
      .square.col-xs-2{"data-y" => $i, "data-x" => $j}

.info.col-xs-3
  %ul
    %li Time (25 s / 30)
    //Mozna budicek?

@stop