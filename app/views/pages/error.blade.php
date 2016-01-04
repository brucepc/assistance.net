@extends('layouts.paper')
<?php $page_title = $error ?>

@section('content')
@include('sections.topbar')
@include('sections.topribbons')

<div class='vspace'></div>
<div class='text-center'>
	<h1 class='theme-error space-bottom'>{{ trans('errors.title') }}</h1>
	<div class='vspace'></div>
	<h2 id='err-name'>{{{ @$error }}}</h2>
	<div id='err-code' class='hint space-top'>{{ $code ?: 500 }}</div>
	<div class='big-vspace'></div>
	<div id='sad-face'>:(</div>
</div>
@include('sections.footer')
@stop