@extends('layouts.paper')
<?php $page_title = $title ?>

@section('head')
@parent
<style type='text/css'>
	#msg-name {
		margin: auto;
		max-width: 90%;
		word-wrap: break-word;
	}
</style>
@stop

@section('content')
@include('sections.topbar')
@include('sections.topribbons')

<div class='vspace'></div>
<div class='text-center'>
	<h1 class='theme-indeterminate pad'>{{ @$title }}</h1>
	<div class='vspace'></div>
	<h2 id='msg-name'>{{{ @$message }}}</h2>
	<div class='vspace'></div>
</div>
@include('sections.footer')
@stop
