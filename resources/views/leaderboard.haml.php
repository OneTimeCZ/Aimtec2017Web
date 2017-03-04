@extends('layouts.app')

@section('title', 'Leaderboard')

@section('content')

.title Leader board

%table.leaderboard.col-xs-offset-2.col-xs-8
  %tr
    %th.text-center.col-xs-2 Rank
    %th.text-center.col-xs-8 Name
    %th.text-center.col-xs-2 Score
  %tr
    %td.text-center 1
    %td.text-center vasek masek
    %td.text-center 25
  %tr
    %td.text-center 2
    %td.text-center tomas kveton
    %td.text-center 23
  %tr
    %td.text-center 3
    %td.text-center martin bruna
    %td.text-center 20
  %tr
    %td.text-center 4
    %td.text-center martin brom
    %td.text-center 19
  %tr
    %td.text-center 5
    %td.text-center mirek krysl
    %td.text-center 17

@stop