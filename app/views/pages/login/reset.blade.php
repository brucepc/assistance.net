@extends('layouts.blade')
<?php $page_title = Lang::get('login/reset.page_title') ?>

@section('content')

{{ Form::open([ 'action' => 'LoginController@DoReset', 'style' => 'position: relative', 'class' => 'login-form', 'id' => 'reset-form' ]) }}

<p>{{ trans('login/reset.title') }}</p>
<p class='hint space-bottom'>{{ trans('login/reset.change_comment') }}</p>
@if ($errors->has('password'))
<div class='form-error'>{{ $errors->first('password') }}</div>
@endif
{{ Form::hidden('email', $email) }}
{{ Form::hidden('token', $token) }}
{{ Form::label('password', trans('login/reset.labels.password')) }}
{{ Form::password('password') }}
{{ Form::infolabel('password_confirm', trans('login/reset.labels.password'), trans('login/reset.labels.password_confirm')) }}
{{ Form::password('password_confirm') }}

<div id='bottom-right'>
    {{ Form::submit(trans('login/reset.reset_button'), [ 'class' => 'iblock button' ]) }}
    <a class='button iblock button-error' id='login-cancel' href='{{ action('LoginController@ShowLogin') }}'>{{ trans('shared.buttons.cancel') }}</a>
</div>

{{ Form::close() }}

@stop
