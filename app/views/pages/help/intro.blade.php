@extends('layouts.paper')
<?php $page_title = 'Help' ?>

@section('head')
@parent
@include('sections.debugmenu')
@stop

@section('content')
@include('sections.topbar')
@include('sections.noscript')
@include('sections.topribbons')
<div id='box'>
    @include('sections.help.sidebar')
    <div id='main'>
        <div class='row'>
            <h2>{{ trans('help/intro.title') }}</h2><hr>
            {{ trans('help/intro.content') }}
        </div>
    </div>
</div>
@include('sections.footer')
@stop