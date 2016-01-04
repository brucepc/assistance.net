@extends('layouts.blade')
<?php $page_title = trans('login/forgot.page_title') ?>

@section('content')

{{ Form::open([ 'action' => 'LoginController@DoForgot', 'style' => 'position: relative', 'class' => 'login-form', 'id' => 'forgot-form' ]) }}

@if ($errors->has('reset'))
<div class='form-error'>{{ $errors->first('reset') }}</div>
@endif

<p>{{ trans('login/forgot.title') }}</p>
<p class='space-bottom hint'><i class='fico-exclamation'></i> {{ trans('login/forgot.third_warning') }}</p>

@if ($errors->has('email'))
<div class='form-error'>{{ $errors->first('email') }}</div>
@endif
{{ Form::label('email', trans('shared.labels.email')) }}
{{ Form::email('email', Input::old('email')) }}

<div id='bottom-right'>
    {{ Form::submit(trans('login/forgot.send_button'), [ 'class' => 'iblock button' ]) }}
    <a class='button iblock button-error' id='login-cancel' href='{{ action('LoginController@ShowLogin') }}'>{{ trans('shared.buttons.cancel') }}</a>
</div>

{{ Form::close() }}

@stop
