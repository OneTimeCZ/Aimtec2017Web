@extends('layouts.app')

@section('title')

#{ trans('layout.login.page') }

@stop

@section('content')

.row
  .col-md-8.col-md-offset-2
    .panel.panel-default
      .panel-heading
        #{ trans('layout.login.page') }
      .panel-body
        %form.form-horizontal{role: "form", method: "POST", action: route('login.post')}
          {{ csrf_field() }}
          .form-group{class: $errors->has('email') ? 'has-error' : ''}
            %label.col-md-4.control-label{for: "email"} #{ trans('layout.email') }
            .col-md-6
              %input#email.form-control{type: "email", name: "email", value: old('email'), required: "required", autofocus: "autofocus"}
              - if ($errors->has('email'))
                %span.help-block
                  %strong {{ $errors->first('email') }}

          .form-group{class: $errors->has('password') ? 'has-error' : ''}
            %label.col-md-4.control-label{for: "password"} #{ trans('layout.password') }
            .col-md-6
              %input#password.form-control{type: "password", name: "password", required: "required"}
              - if ($errors->has('password'))
                %span.help-block
                  %strong {{ $errors->first('password') }}

          .form-group.text-left
            .col-md-6.col-md-offset-4
              .checkbox
                %label
                  %input{type:"checkbox", name: "remember"} #{ trans('layout.remember_me') }

          .form-group.text-left
            .col-md-8.col-md-offset-4
              %button.btn.btn-primary{type: "submit"} #{ trans('layout.login.action') }
              %a.btn.btn-link{href: route('password.email.get')} #{ trans('layout.forgot_password.question') }

@stop
