@extends('layouts.blade')
<?php $page_title = Lang::get('login/login.page_title') ?>

@section('content')

{{ Form::open([ 'action' => 'LoginController@DoLogin', 'style' => 'position: relative', 'class' => 'login-form', 'id' => 'login-form' ]) }}

@if ($errors->has('email'))
<div class='form-error'>{{ $errors->first('email') }}</div>
@endif
{{ Form::label('email', trans('shared.labels.email')) }}
{{ Form::email('email', Input::old('email')) }}

@if ($errors->has('password'))
<div class='form-error'>{{ $errors->first('password') }}</div>
@endif
{{ Form::label('password', trans('shared.labels.password')) }}
{{ Form::password('password') }}

<div>
	<div class='float-right text-right'>
		<a class='small block' id='forgot' href='{{ action('LoginController@ShowForgot') }}' tabindex='0'>{{ trans('login/login.links.forgot') }}</a>
		<a class='small block' id='create' href='{{ true }}' tabindex='0'>{{ trans('login/login.links.create') }}</a>
	</div>
	<div class='big' id='caps-lock'><i class='fico-exclamation'></i> {{ trans('login/login.caps_warning') }}</div>
</div>
<div class='small-vspace'></div>
<div id='bottom-left'>{{ Form::stylecheck('remember', trans('login/login.remember_check')) }}</div>
<div id='bottom-right'>
	{{ Form::submit('Login', [ 'class' => 'iblock button' ]) }}
	<a class='button button-error' id='login-cancel' href='{{ route('home') }}'>Cancel</a>
</div>

{{ Form::close() }}

@stop