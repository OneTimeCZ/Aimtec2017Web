@extends('layouts.app')

@section('title', 'Game lobby')

@section('content')

.title Game lobby

.row
  - for($i = 0; $i < 8; $i++)
    .col-sm-3.col-lg-3
      .dash-unit
        %h2.title Game #{47+$i}
        %a.game-link{href: "game/#{47+$i}"}
          %img.game-logo{src: "images/laser.png"}
        Runner:
        %a.player-name testplayer#{123+$i}
  %btn.btn.btn-lg.btn-default.text-center#loadMore Load more

@stop
