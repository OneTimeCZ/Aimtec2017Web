@extends('layouts.app')

@section('content')

.title#landingTitle Runners & Hunters

.slogan Just run away...

.circle-row
  .circle.col-xs-4
    .inner
      %a{href: "/how-to-play"}
        %img{src: "images/laser.png"}
        %i.text-center.fa.fa-question
    %p.text-center How to play
  .circle.col-xs-4
    .inner
      %a{href: "/lobby"}
        %img{src: "images/laser.png"}
        %i.text-center.fa.fa-play
    %p.text-center Play
  .circle.col-xs-4
    .inner
      %a{href: "/leaderboard"}
        %img{src: "images/laser.png"}
        %i.text-center.fa.fa-trophy.leaderb
    %p.text-center Leader board

@stop
