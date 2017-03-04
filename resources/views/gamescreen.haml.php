@extends('layouts.app')

@section('title', 'Game 88')

@section('content')

.title Build phase

%script{type: "text/javascript", src: "js/game.js"}

.weapons.col-xs-3
  %ul
    %li.weapon.time-bomb.selected{"data-id" => "1"}
      %img.mini-item{"src" => "images/bomb.png"}
      %p.text-left (1) Bomb
      %p.ammo
    %li.weapon.flame{"data-id" => "2"}
      %img.mini-item{"src" => "images/fire.png"}
      %p.text-left (2) Flame
      %p.ammo
    %li.weapon.target{"data-id" => "3"}
      %img.mini-item{"src" => "images/cactus.png"}
      %p.text-left (3) Cactus
      %p.ammo

.grid.hoverable.col-xs-6
  - for($i = 0; $i < 6; $i++)
    .row
    - for($j = 0; $j < 6; $j++)
      .grid-square.col-xs-2.hover{"data-y" => $i, "data-x" => $j}

.info.col-xs-3
  .clock-container
    %img.clock{src: "images/clock2.png"}
    %p.countdown 30

@stop

.modal.fade#preGameModal{role: "dialog"}
  .modal-dialog
    .modal-content
      .modal-header
        %button{type: "button", class: "close", "data-dismiss" => "modal"} &times;
        %h4.modal-title Epic Game
      .modal-body
        %h1.text-center Welcome to the game #47
        %h4.text-center
          You are facing:
          %a.player-name testplayer123
        %h4.text-center
          The game will begin shortly after both you and your enemy press "Ready"
        %button.btn.btn-lg.text-center.btn-danger#startGame{type: "button", "data-dismiss" => "modal"} READY