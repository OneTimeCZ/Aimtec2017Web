<!DOCTYPE html>
%html{lang: "en"}
  %head
    %base{href: URL::asset('/')}
    %meta{charset: "utf-8"}
    %meta{content: "width=device-width, initial-scale=1", name: "viewport"}
    %meta{content: "{{ csrf_token() }}", name: "csrf-token"}
    %title @yield('title', 'Laravel 5')
    %link{rel: "stylesheet", type: "text/css", href: "https://fonts.googleapis.com/css?family=Lato:100"}
    %link{rel: "stylesheet", type: "text/css", href: "bundles/bundle.css"}
    %link{rel: "stylesheet", type: "text/css", href: "bundles/main.css"}
    %link{rel: "stylesheet", type: "text/css", href: "css/app.css"}
    %script{type: "text/javascript", src: "bundles/bundle.js"}
    //%script{type: "text/javascript", src: "js/restfulizer.js"}
    %script{type: "text/javascript", src: "js/app.js"}
  %body
    %nav.navbar.navbar-default#navb
      .container
        .navbar-header
          %button.navbar-toggle.collapsed{"aria-controls" => "navbar", "aria-expanded" => "false", "data-target" => "#navbar", "data-toggle" => "collapse", :type => "button"}
            %span.sr-only #{ trans('layout.toggle_navigation') }
            %span.icon-bar
            %span.icon-bar
            %span.icon-bar
          %a.navbar-brand#brand{:href => "/"} Epic Game
        #navbar.navbar-collapse.collapse
          %ul.nav.navbar-nav
            @section('navigation')
            - if(Auth::user())
              %li
                %a{href: route('game.lobby.get')} Game lobby
            @show

          %ul.nav.navbar-nav.navbar-right
            - if(Auth::user())
              %li
                %a{href: '#'}
                  = Auth::user()->name
              %li
                %a{href: route('logout.post'), 'data-method' => "DELETE", 'data-token' => csrf_token()} #{ trans('layout.logout.action') }
            - else
              %li
                %a{href: route("login.get")} #{ trans('layout.login.action') }
              %li
                %a{href: route("register.get")} #{ trans('layout.register.action') }

    .container
      .content
        @yield('content')
