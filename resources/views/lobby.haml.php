@extends('layouts.app')

@section('title', 'Game lobby')

@section('content')

.title Game lobby

.row
  .col-sm-3.col-lg-3
    .dash-unit
      %h2.title Game 88
      %a.game-link{href: "game/88"}
        %img.game-logo{src: "images/laser.png"}
      Runner:
      %a.player-name testusername123

@stop
