@extends('layouts.paper')
<?php $page_title = $profile->name ?>

@section('content')
@include('sections.topbar')
@include('sections.noscript')
@include('sections.topribbons')

<div class='small-vspace'></div>
<h1 class='text-center pad-text theme-profile'>{{{ $profile->name }}}</h1>

@include('sections.footer')
@stop