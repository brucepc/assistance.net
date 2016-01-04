@extends('page')
@section('head')
@parent
<link rel='stylesheet' href='{{ asset('style/layouts/metal.css') }}'>
@stop

@section('body')
<body>
	@include('sections.topribbons')
	@yield('content')
</body>
@stop
