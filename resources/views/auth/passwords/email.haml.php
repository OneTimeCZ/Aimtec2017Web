@extends('layouts.app')

@section('title')

#{ trans('layout.reset_password.page') }

@stop

@section('content')

.row
  .col-md-8.col-md-offset-2
    .panel.panel-default
      .panel-heading
        #{ trans('layout.reset_password.page') }
      .panel-body
        - if (session('status'))
          .alert.alert-success
            {{ session('status') }}
        %form.form-horizontal{role: "form", method: "POST", action: route('password.email.post')}
          {{ csrf_field() }}
          .form-group{class: $errors->has('email') ? 'has-error' : ''}
            %label.col-md-4.control-label{for: "email"} #{ trans('layout.email') }
            .col-md-6
              %input#email.form-control{type: "email", name: "email", value: old('email'), required: "required"}
              - if ($errors->has('email'))
                %span.help-block
                  %strong {{ $errors->first('email') }}

          .form-group.text-left
            .col-md-6.col-md-offset-4
              %button.btn.btn-primary{type: "submit"} #{ trans('layout.send_password_reset') }

@stop
