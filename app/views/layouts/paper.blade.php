@extends('page')

@section('head')
@parent
<link rel='stylesheet' href='{{ asset('style/layouts/paper.css') }}'>
@include('sections.debugmenu')
@stop

@section('body')
<body class='bottom-{{{ $theme }}}'>
	@yield('content')
</body>
@stop