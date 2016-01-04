@extends('page')
@section('head')
@parent
<link rel='stylesheet' href='{{ asset('style/layouts/blade.css') }}'>
@stop

@section('body')
<body>
	<!--<script type='IN/Login' data-onauth='onLinkedInAuth'></script>-->
	<div class='blade theme-profile'>
		<div class='gloss'></div>
		<a id='asst-logo' href='{{ route('home') }}' class='fico-assistance'></a>
		<hr>
		@include('sections.topribbons')
		@yield('content')
		<div class='module module-footer'>@include('sections.footer')</div>
	</div>
</body>
@stop
