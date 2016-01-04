@extends('layouts.paper')
<?php $page_title = trans('profile/create.page_title') ?>

@section('content')
@include('sections.topbar')
@include('sections.noscript')
@include('sections.topribbons')

<style>
#create-form { padding-top: 20px; max-width: 60%; margin: auto; }
fieldset { text-align: left; display: inline-table; margin: 10px; vertical-align: top; }
</style>

{{ Form::open([ 'action' => 'ProfileController@DoNew', 'id' => 'create-form', 'autocomplete' => 'off' ]) }}

<h1>{{ trans('profile/create.title') }}</h1>
<div class='hint'>{{ trans('profile/create.subtitle') }}</div>
<div class='vspace'></div>

<fieldset>
    <h2>{{ trans('profile/create.account.title') }}</h2>
    <div class='hint'>{{ trans('profile/create.account.subtitle') }}</div>
    {{ Form::infolabel('email', trans('profile/create.account.email.title'), trans('profile/create.account.email.subtitle')) }}<br>
    @if ($errors->has('email')) @foreach ($errors->get('email') as $err) <div class='form-error'>{{ $err }}</div>@endforeach @endif
    {{ Form::email('email', Input::old('email')) }}<br>
    {{ Form::label('password', trans('profile/create.account.password.title')) }}<br>
    @if ($errors->has('password')) @foreach ($errors->get('password') as $err) <div class='form-error'>{{ $err }}</div>@endforeach @endif
    {{ Form::password('password') }}<br>
    {{ Form::infolabel('password_confirmation', trans('profile/create.account.password.title'), trans('profile/create.account.password.subtitle')) }}<br>
    @if ($errors->has('password_confirmation')) @foreach ($errors->get('password_confirmation') as $err) <div class='form-error'>{{ $err }}</div>@endforeach @endif
    {{ Form::password('password_confirmation') }}
</fieldset>

<fieldset>
    <h2>{{ trans('profile/create.profile.title') }}</h2>
    <div class='hint'>{{ trans('profile/create.profile.subtitle') }}</div>
    {{ Form::infolabel('name', trans('profile/create.profile.name.title'), trans('profile/create.profile.name.subtitle')) }}<br>
    @if ($errors->has('name')) @foreach ($errors->get('name') as $err) <div class='form-error'>{{ $err }}</div>@endforeach @endif
    {{ Form::text('name', Input::old('name')) }}
</fieldset>

<div class='vspace'></div>
<hr>
{{ Form::submit(trans('profile/create.create_button'), [ 'class' => 'button-success float-right' ]) }}
<div class='hint'>{{ trans('profile/create.more_comment') }}</div>

{{ Form::close() }}

@include('sections.footer')
@stop
